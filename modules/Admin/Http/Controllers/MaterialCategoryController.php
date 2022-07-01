<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;

class MaterialCategoryController extends Controller
{
    /**
     * MaterialGroupController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new MaterialCategory);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $offset             = ($request->has('offset')) ? $request->input('offset') : 0;
        $materialCategories = $this->getModel()
            ->orderBy('sort')
            ->get();

        if ($request->ajax()) {
            return view('admin::material-category.row', compact('materialCategories'));
        }

        return view('admin::material-category.list', [
            'materialCategories' => $materialCategories,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin::material-category.add');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $materialCategoryEntity = new MaterialCategory;

        $materialCategoryEntity->title = $request->input('title');
        $materialCategoryEntity->save();

        $materialCategory = $this->getModel()->get();
        $offset           = ($request->has('offset')) ? $request->input('offset') : 0;
        $limit            = $this->getLimit();
        $count            = parent::getEntitiesCount();

        return redirect()->route('admin::view.material-categories',
            compact('materialCategory', 'limit', 'offset', 'count'))
            ->withStatus('Material category added successfully');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $materialCategory = MaterialCategory::find($id);

        return view('admin::material-category.edit', compact('materialCategory'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeEdit(Request $request, $id)
    {
        $materialCategory = MaterialCategory::find($id);

        if (!$materialCategory) {
            return back()->withStatus('Something has gone wrong, please try again late');
        }

        $materialCategory->title = $request->input('title');
        $materialCategory->save();

        return redirect()->route('admin::edit.material-category', compact('id', 'materialCategory'))
            ->withStatus('Material category updated successfully');
    }

    /**
     * @param $materialId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeMaterial($materialId)
    {
        $materialCategory = Material::whereId($materialId);

        if (!$materialCategory->update(['material_category_id' => null])) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry something went wrong, please try again later.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully removed material from this material category.'
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function delete(Request $request, $id)
    {
        $materialCategory = MaterialCategory::find($id);

        if (!$materialCategory->materials->isEmpty()) {
            return back()->withError('Material Group could not be deleted as it has materials assigned to it.');
        }

        $materialCategory->delete();

        $offset             = ($request->has('offset')) ? $request->input('offset') : 0;
        $limit              = $this->getLimit();
        $count              = parent::getEntitiesCount();
        $materialCategories = MaterialCategory::get();

        return redirect()->route('admin::view.material-categories',
            compact('materialCategories', 'limit', 'offset', 'count'))
            ->withStatus('Material Group has been successfully deleted');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(Request $request, $id)
    {
        if (!MaterialCategory::whereId($id)->update(['sort' => $request->get('sort')])) {
            return response()->json([
                'success' => false,
                'message' => 'Something has gone wrong the material category sort has not been updated.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully updated the material category sort.'
        ]);
    }

}
