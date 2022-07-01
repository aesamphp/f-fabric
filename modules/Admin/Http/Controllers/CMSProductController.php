<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSProduct;
use App\Models\Category;

class CMSProductController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->setModel(new CMSProduct);
    }
    
    public function showProducts(Request $request) {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $products = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::cms-products.product-row', ['products' => $products]);
        }
        return view('admin::cms-products.products', [
            'products' => $products,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function newProduct(Request $request) {
        return view('admin::cms-products.new-product', [
            'categories' => Category::getShoppableCategories()
        ]);
    }
    
    public function storeProduct(Request $request) {
        $redirect = redirect()->route('admin::new.cms.product');
        $imageFiles = $request->file('files');
        foreach ($imageFiles as $key => $image) {
            if ($image !== null) {
                $validator = parent::validateImage(['file' => $image]);
                if ($validator->fails()) {
                    return $redirect->withErrors($validator)
                            ->withInput();
                }
                $filePath = parent::uploadFile($image, CMSProduct::IMAGE_DESTINATION_PATH);
                $request->merge([$key => $filePath]);
            }
        }
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.cms.product', ['id' => $entity->id])
                ->with('status', 'Product created!');
    }
    
    public function showProduct(Request $request, $id) {
        return view('admin::cms-products.product', [
            'product' => parent::getEntity($id),
            'categories' => Category::getShoppableCategories()
        ]);
    }
    
    public function updateProduct(Request $request, $id) {
        $redirect = redirect()->route('admin::view.cms.product', ['id' => $id]);
        $imageFiles = $request->file('files');
        foreach ($imageFiles as $key => $image) {
            if ($image !== null) {
                $validator = parent::validateImage(['file' => $image]);
                if ($validator->fails()) {
                    return $redirect->withErrors($validator)
                            ->withInput();
                }
                $filePath = parent::uploadFile($image, CMSProduct::IMAGE_DESTINATION_PATH);
                $request->merge([$key => $filePath]);
            }
        }
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Product updated!');
    }
    
    public function deleteProduct(Request $request, $id) {
        parent::deleteEntity($id);
        return redirect()->route('admin::view.cms.products')
                ->with('status', 'Product deleted!');
    }

}
