<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->setModel(new Category);
    }

    public function showCategories(Request $request) {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $categories = parent::getEntities($offset, [
            ['column' => 'disabled', 'condition' => '=', 'value' => 0]
        ]);
        if ($request->ajax()) {
            return view('admin::category.category-row', ['categories' => $categories]);
        }
        return view('admin::category.categories', [
            'categories' => $categories,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function newCategory(Request $request) {
        return view('admin::category.new-category');
    }
    
    public function storeCategory(Request $request) {
        $redirect = redirect()->route('admin::new.category');
        if ($request->hasFile('file')) {
            $validator = parent::validateImage($request->all());
            if ($validator->fails()) {
                return $redirect->withErrors($validator)
                        ->withInput();
            }
            $filePath = parent::uploadFile($request->file('file'), Category::IMAGE_DESTINATION_PATH);
            $request->merge(['image_path' => $filePath]);
        }
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.category', ['id' => $entity->id])
                ->with('status', 'Category created!');
    }
    
    public function showCategory(Request $request, $id) {
        return view('admin::category.category', ['category' => parent::getEntity($id)]);
    }
    
    public function updateCategory(Request $request, $id) {
        $redirect = redirect()->route('admin::view.category', ['id' => $id]);
        if ($request->hasFile('file')) {
            $validator = parent::validateImage($request->all());
            if ($validator->fails()) {
                return $redirect->withErrors($validator)
                        ->withInput();
            }
            $filePath = parent::uploadFile($request->file('file'), Category::IMAGE_DESTINATION_PATH);
            $request->merge(['image_path' => $filePath]);
        }
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Category updated!');
    }
    
    public function deleteCategory(Request $request, $id) {
        parent::deleteEntity($id);
        return redirect()->route('admin::view.categories')
                ->with('status', 'Category deleted!');
    }

}
