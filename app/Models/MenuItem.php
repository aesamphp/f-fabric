<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends AppModel
{
    const IMAGE_DESTINATION_PATH = 'uploads/images/menu_items';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'route',
        'menu_id',
        'menu_section_id',
        'sort_order',
        'active',
        'image_path',
        'excerpt',
    ];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort_order' => 'required',
            'title' => 'required',
            'route' => 'required',
            'menu_section_id' => 'required',
        ];
    }

    /**
     * Set model validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'sort_order.required' => 'The sort field is required.',
            'title.required' => 'The title field is required.',
            'route.required' => 'The page field is required.',
            'menu_section_id.required' => 'The section field is required.',
        ];
    }

    /**
     * Retrieve parent menu
     *
     * @return BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Retrieve parent menu section
     *
     * @return BelongsTo
     */
    public function menuSection()
    {
        return $this->belongsTo(MenuSection::class);
    }
}
