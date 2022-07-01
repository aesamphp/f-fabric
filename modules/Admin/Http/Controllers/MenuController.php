<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuSection;
use App\Services\ListRoutesService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Menu);
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function showMenus(Request $request)
    {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $menus = parent::getEntities($offset);

        if ($request->ajax()) {
            return view('admin::menu.menu-row', compact('menus'));
        }

        return view('admin::menu.index')
            ->withMenus($menus)
            ->withLimit($this->getLimit())
            ->withOffset($offset)
            ->withCount(parent::getEntitiesCount());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function showMenu($id)
    {
        $menu = parent::getEntity($id);

        return view('admin::menu.show')
            ->withMenu($menu)
            ->withMenuSectionsList(MenuSection::getMenuSectionsList($menu->id))
            ->withRoutes(ListRoutesService::getRoutesDropdown());
    }
}
