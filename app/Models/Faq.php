<?php

namespace App\Models;

class Faq extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faqs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'title', 'content'];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules() {
        return [
            'category_id' => 'required|integer',
            'title' => 'required|max:250',
            'content' => 'required'
        ];
    }

    /**
     * Get the category that belongs to faq.
     *
     * @return array
     */
    public function category() {
        return $this->belongsTo('App\Models\FaqCategory');
    }

    /**
     * Return the search faqs
     *
     * @param string $keyword
     *
     * @return array
     */
    static function searchFaqs($keyword)
    {
        return Faq::where('title', 'like', $keyword)->orWhere('content', 'like', $keyword)->get();
    }
}
