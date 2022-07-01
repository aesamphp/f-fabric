<?php

namespace App\Http\ViewComposers;

use App\Models\Menu;
use Illuminate\View\View;

class HeaderMenuComposer
{
    /**
     * @var Menu Instance of menu model
     */
    private $menu;

    /**
     * Create a new menu composer.
     *
     * @param  int $menuId
     * @return void
     */
    public function __construct($menuId = Menu::NAV_MENU_ID)
    {
        $this->menu = Menu::with('menuSections')->find($menuId);
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('menu', $this->menu);
    }
}
