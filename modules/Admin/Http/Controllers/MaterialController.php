<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialGroup;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Material);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMaterials(Request $request)
    {
        $offset    = ($request->has('offset')) ? $request->input('offset') : 0;
        $materials = parent::getEntities($offset, [
            ['column' => 'disabled', 'condition' => '=', 'value' => 0]
        ], ['column' => 'code', 'type' => 'ASC']);

        if ($request->ajax()) {
            return view('admin::material.material-row', ['materials' => $materials]);
        }

        return view('admin::material.materials', [
            'materials' => $materials,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newMaterial()
    {
        return view('admin::material.new-material', [
            'groups' => MaterialGroup::all(),
            'materialCategories' => MaterialCategory::all()]
        );
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function storeMaterial(Request $request)
    {
        $redirect = redirect()->route('admin::new.material');
        $entity   = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.material', ['id' => $entity->id])
            ->with('status', 'Material added!');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMaterial($id)
    {
        return view('admin::material.material', [
            'materialCategories' => MaterialCategory::all(),
            'groups' => MaterialGroup::all(),
            'material' => parent::getEntity($id)
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateMaterial(Request $request, $id)
    {
        $redirect = redirect()->route('admin::view.material', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Material updated!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteMaterial($id)
    {
        parent::deleteEntity($id);
        return redirect()->route('admin::view.materials')
            ->with('status', 'Material deleted!');
    }
}
