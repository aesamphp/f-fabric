<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogArticle;
use App\Models\BlogComment;

class BlogController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->setModel(new BlogArticle);
    }
    
    public function showArticles(Request $request) {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $articles = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::blog.article-row', ['articles' => $articles]);
        }
        return view('admin::blog.articles', [
            'articles' => $articles,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function newArticle(Request $request) {
        return view('admin::blog.new-article');
    }
    
    public function storeArticle(Request $request) {
        $redirect = redirect()->route('admin::new.blog.article');
        if (!$request->has('image_path') || $request->hasFile('file')) {
            $validator = parent::validateImage($request->all());
            if ($validator->fails()) {
                return $redirect->withErrors($validator)
                        ->withInput();
            }
            $filePath = parent::uploadFile($request->file('file'), BlogArticle::IMAGE_DESTINATION_PATH);
            $request->merge(['image_path' => $filePath]);
        }
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.blog.article', ['id' => $entity->id])
                ->with('status', 'Article created!');
    }
    
    public function showArticle(Request $request, $id) {
        return view('admin::blog.article', ['article' => parent::getEntity($id)]);
    }
    
    public function updateArticle(Request $request, $id) {
        $redirect = redirect()->route('admin::view.blog.article', ['id' => $id]);
        if (!$request->has('image_path') || $request->hasFile('file')) {
            $validator = parent::validateImage($request->all());
            if ($validator->fails()) {
                return $redirect->withErrors($validator)
                        ->withInput();
            }
            $filePath = parent::uploadFile($request->file('file'), BlogArticle::IMAGE_DESTINATION_PATH);
            $request->merge(['image_path' => $filePath]);
        }
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Article updated!');
    }
    
    public function deleteArticle(Request $request, $id) {
        parent::deleteEntity($id);
        return redirect()->route('admin::view.blog.articles')
                ->with('status', 'Article deleted!');
    }
    
    public function showArticleComments(Request $request, $id) {
        $this->setModel(new BlogComment);
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $comments = parent::getEntities($offset, [
            ['column' => 'article_id', 'condition' => '=', 'value' => $id]
        ]);
        if ($request->ajax()) {
            return view('admin::blog.article-comment-row', ['comments' => $comments]);
        }
        return view('admin::blog.article-comments', [
            'comments' => $comments,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function deleteArticleComment(Request $request, $id, $commentId) {
        $this->setModel(new BlogComment);
        parent::deleteEntityByFields([
            ['column' => 'article_id', 'condition' => '=', 'value' => $id],
            ['column' => 'id', 'condition' => '=', 'value' => $commentId]
        ]);
        return redirect()->route('admin::view.blog.article.comments', ['id' => $id])
                ->with('status', 'Comment deleted!');
    }
    
    public function showArticleCommentContent(Request $request, $id, $commentId) {
        $this->setModel(new BlogComment);
        return view('admin::blog.article-comment-content', ['comment' => parent::getEntityByFields([
            ['column' => 'article_id', 'condition' => '=', 'value' => $id],
            ['column' => 'id', 'condition' => '=', 'value' => $commentId]
        ])]);
    }

}
