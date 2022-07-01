<?php

namespace App\Models;

use App\Models\AppModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends AppModel
{
    const NAV_MENU_ID = 1;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "menus";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
        ];
    }

    /**
     * Retrieve related menu sections
     *
     * @return HasMany
     */
    public function menuSections()
    {
        return $this->hasMany(MenuSection::class);
    }

    /**
     * Retrieve related menu items
     *
     * @return HasMany
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
