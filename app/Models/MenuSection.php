<?php

namespace App\Models;

use App\Models\AppModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuSection extends AppModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menu_sections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'menu_id',
        'active',
        'excerpt',
        'url',
    ];

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
     * Retrieve related menu items
     *
     * @return HasMany
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class)
            ->orderBy('sort_order')
            ->whereActive(true);
    }

    public static function getMenuSectionsList($menuId)
    {
        return self::whereMenuId($menuId)
            ->get()
            ->pluck('id', 'title');
    }
}
