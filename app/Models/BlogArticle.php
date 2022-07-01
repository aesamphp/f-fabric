<?php

namespace App\Models;

class BlogArticle extends AppModel {
    
    const IMAGE_DESTINATION_PATH = 'uploads/images/blog';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blog_articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'image_path', 'excerpt', 'content', 'meta_description', 'meta_keywords', 'tags', 'active'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['meta_description', 'meta_keywords', 'tags'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required|max:250',
            'image_path' => 'required',
            'excerpt' => 'required',
            'content' => 'required',
            'active' => 'required|boolean'
        ];
    }
    
    /**
     * Get the user that belongs to article.
     * 
     * @return array
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * Get the comments that belongs to article.
     * 
     * @return array
     */
    public function comments() {
        return $this->hasMany('App\Models\BlogComment', 'article_id');
    }
    
    /**
     * Returns the comments count that belongs to article.
     * 
     * @return int
     */
    public function getCommentsCount() {
        return $this->comments()->count();
    }

    /**
     * Fetch blogs and group by month.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getArticlesByMonth()
    {
        return $this->where('title', '!=', '')
            ->whereActive(true)
            ->select(['title', 'identifier', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($item) { 
                return $item->created_at->format('F Y'); 
            });
    }
    
    /**
     * Function to perform default actions on events.
     */
    protected static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->user_id = getAuthenticatedUser()->id;
            $model->setIdentifier($model->title);
        });
        static::updating(function($model) {
            $model->setIdentifier($model->title);
        });
    }

}
