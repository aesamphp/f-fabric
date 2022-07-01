<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\MenuSection;
use App\Services\ListRoutesService;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new MenuItem);
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function store(Request $request)
    {
        if (!parent::isValid($request->all())) {
            return redirect()->route('admin::view.menu', ['id' => $request->get('id')])
                ->withErrors(parent::getErrors($request->all()));
        }

        $menuItem = parent::save($request->all());

        return redirect()->route('admin::view.menu', ['id' => $menuItem->menu_id])
            ->withStatus('Menu Item Created.');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $menuItem = MenuItem::find($id);

        if (!$menuItem) {
            return redirect()->route('admin::view.menus')
                ->withError('Menu Item does not exist');
        }

        return view('admin::menu-items.show')
            ->withMenuitem($menuItem)
            ->withMenusectionslist(MenuSection::getMenuSectionsList($menuItem->menu_id))
            ->withRoutes(ListRoutesService::getRoutesDropdown());
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return mixed
     */
    public function edit(Request $request, $id)
    {
        $redirect = redirect()->route('admin::view.menuitem', ['id' => $id]);

        if (!$request->has('image_path') || $request->hasFile('file')) {
            $imagePath = $this->setImagePath($request, $redirect);
            $request->merge(['image_path' => $imagePath]);
        }

        parent::updateEntity($request->all(), $id, $redirect);

        return $redirect->withStatus('Menu item has been updated');
    }

    /**
     * @param Request $request
     * @param $redirect
     *
     * @return string
     */
    public function setImagePath(Request $request, $redirect)
    {
        $validator = parent::validateImage($request->all());

        if ($validator->fails()) {
            return $redirect->withErrors($validator)->withInput();
        }

        return parent::uploadFile($request->file('file'), MenuItem::IMAGE_DESTINATION_PATH);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        $menuItem = MenuItem::find($id);
        $menuItem->delete();

        return redirect()->route('admin::view.menu', ['id' => $menuItem->menu_id])
            ->withStatus('Menu item successfully deleted');
    }
}
