<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogArticle;
use App\Models\BlogComment;
use App\Models\Design;

class BlogController extends Controller {

    const BLOG_PAGINATION_LIMIT = 2;
    
    public function __construct() {
        parent::__construct();
        $this->setModel(new BlogArticle);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->setLimit(self::BLOG_PAGINATION_LIMIT);
        $blogs = $this->fetchPaginatedBlogs($this->getLimit());

        return view('blog.index', [
            'blogs' => $blogs,
            'sidebarArticles' => $this->model->getArticlesByMonth()
        ]);
    }
    
    /**
     * Return paginated blog articles to AJAX.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function blogPagination(Request $request)
    {
        $this->setLimit(self::BLOG_PAGINATION_LIMIT);
        $blogs = $this->fetchPaginatedBlogs($this->getLimit());

        return response()->json([
            'count' => $blogs->total(),
            'html' => view('blog.pagination', compact('blogs'))->render()
        ]);
    }
    
    /**
     * Show a blog article.
     *
     * @param Request $request
     * @param string $identifier
     * 
     * @return Illuminate\View\View
     */
    public function showBlogArticle(Request $request, $identifier) {
        return view('blog.article', [
            'article' => parent::getEntityByIdentifier($identifier, [
                ['column' => 'active', 'condition' => '=', 'value' => 1]
            ]),
            'sidebarArticles' => $this->model->getArticlesByMonth()
        ]);
    }
    
    /**
     * Store new article comment.
     *
     * @param Request $request
     * @param int $id
     * 
     * @return Illuminate\Routing\Redirector
     */
    public function storeBlogArticleComment(Request $request, $id) {
        $article = parent::getEntity($id);
        $this->setModel(new BlogComment);
        $redirect = redirect()->route('view.blog.article', ['identifier' => $article->identifier]);
        $request->merge(['article_id' => $article->id]);
        parent::storeEntity($request->all(), $redirect);
        return $redirect->with('status', 'Comment added successfully.');
    }

    /**
     * Get active blogs and return paginated collection.
     *
     * @param int $limit
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    protected function fetchPaginatedBlogs($limit)
    {
        return $this->model
            ->whereActive(true)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }
}
