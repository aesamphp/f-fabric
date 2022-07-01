<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductMaterial;
use App\Models\ProductQuantity;
use App\Models\ShippingPackageType;
use App\Models\ProductPackageType;
use App\Models\Material;
use App\Models\ProductMaterialQuantity;

class ProductController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->setModel(new Product);
    }

    public function showProducts(Request $request) {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $products = parent::getEntities($offset, [
            ['column' => 'disabled', 'condition' => '=', 'value' => 0]
        ]);
        if ($request->ajax()) {
            return view('admin::product.product-row', ['products' => $products]);
        }
        return view('admin::product.products', [
            'products' => $products,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function newProduct(Request $request) {
        return view('admin::product.new-product', ['categories' => Category::all()]);
    }
    
    public function storeProduct(Request $request) {
        $redirect = redirect()->route('admin::new.product');
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.product', ['id' => $entity->id])
                ->with('status', 'Product added!');
    }

    public function showProduct(Request $request, $id) {
        return view('admin::product.product', [
            'product' => parent::getEntity($id),
            'categories' => Category::all()
        ]);
    }

    public function updateProduct(Request $request, $id) {
        $redirect = redirect()->route('admin::view.product', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Product updated!');
    }
    
    public function deleteProduct(Request $request, $id) {
        parent::deleteEntity($id);
        return redirect()->route('admin::view.products')
                ->with('status', 'Product deleted!');
    }
    
    public function newProductMaterial(Request $request, $id) {
        $product = parent::getEntity($id);
        $productMaterialIds = [];
        foreach ($product->productMaterials as $productMaterial) {
            $productMaterialIds[] = $productMaterial->material_id;
        }
        return view('admin::product.new-product-material', [
            'product' => $product,
            'materials' => Material::whereNotIn('id', $productMaterialIds)->get()
        ]);
    }
    
    public function storeProductMaterial(Request $request, $id) {
        $product = parent::getEntity($id);
        $this->setModel(new ProductMaterial);
        $redirect = redirect()->route('admin::new.product.material', ['id' => $id]);
        $request->merge(['product_id' => $product->id]);
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.product', ['id' => $id])
                ->with('status', 'Product material added!');
    }

    public function showProductMaterial(Request $request, $id, $materialId) {
        $this->setModel(new ProductMaterial);
        if ($materialId === "none") {
            $productMaterial = parent::getEntity($id);
        } else {
            $productMaterial = parent::getEntityByFields([
                ['column' => 'product_id', 'condition' => '=', 'value' => $id],
                ['column' => 'material_id', 'condition' => '=', 'value' => $materialId]
            ]);
        }
        return view('admin::product.product-material', ['productMaterial' => $productMaterial]);
    }

    public function updateProductMaterial(Request $request, $id, $materialId) {
        $this->setModel(new ProductMaterial);
        if ($materialId === "none") {
            $productMaterial = parent::getEntity($id);
        } else {
            $productMaterial = parent::getEntityByFields([
                ['column' => 'product_id', 'condition' => '=', 'value' => $id],
                ['column' => 'material_id', 'condition' => '=', 'value' => $materialId]
            ]);
        }
        $redirect = redirect()->route('admin::view.product.material', ['id' => $id, 'materialId' => $materialId]);
        parent::updateEntity($request->all(), $productMaterial->id, $redirect);
        return $redirect->with('status', 'Product material updated!');
    }
    
    public function deleteProductMaterial(Request $request, $id, $materialId) {
        $this->setModel(new ProductMaterial);
        if ($materialId === "none") {
            $productMaterial = parent::getEntity($id);
        } else {
            $productMaterial = parent::getEntityByFields([
                ['column' => 'product_id', 'condition' => '=', 'value' => $id],
                ['column' => 'material_id', 'condition' => '=', 'value' => $materialId]
            ]);
        }
        $productId = $productMaterial->product_id;
        parent::deleteEntity($productMaterial->id);
        return redirect()->route('admin::view.product', ['id' => $productId])
                ->with('status', 'Product material deleted!');
    }
    
    public function newProductPackageType(Request $request, $id) {
        $product = parent::getEntity($id);
        $packageTypeIds = [];
        foreach ($product->packageTypes as $packageType) {
            $packageTypeIds[] = $packageType->package_type_id;
        }
        return view('admin::product.new-product-package-type', [
            'product' => $product,
            'packageTypes' => ShippingPackageType::whereNotIn('id', $packageTypeIds)->get()
        ]);
    }
    
    public function storeProductPackageType(Request $request, $id) {
        $product = parent::getEntity($id);
        $this->setModel(new ProductPackageType);
        $redirect = redirect()->route('admin::new.product.package.type', ['id' => $id]);
        $request->merge(['product_id' => $product->id]);
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.product', ['id' => $id])
                ->with('status', 'Shipping package type added!');
    }
    
    public function deleteProductPackageType(Request $request, $id, $packageTypeId) {
        $this->setModel(new ProductPackageType);
        parent::deleteEntityByFields([
            ['column' => 'product_id', 'condition' => '=', 'value' => $id],
            ['column' => 'package_type_id', 'condition' => '=', 'value' => $packageTypeId]
        ]);
        return redirect()->route('admin::view.product', ['id' => $id])
                ->with('status', 'Shipping package type deleted!');
    }
    
    public function newProductQuantity(Request $request, $id) {
        $product = parent::getEntity($id);
        return view('admin::product.new-product-quantity', ['product' => $product]);
    }
    
    public function storeProductQuantity(Request $request, $id) {
        $product = parent::getEntity($id);
        $this->setModel(new ProductQuantity);
        $redirect = redirect()->route('admin::new.product.quantity', ['id' => $id]);
        $request->merge(['product_id' => $product->id]);
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.product', ['id' => $id])
                ->with('status', 'Product quantity added!');
    }
    
    public function showProductQuantity(Request $request, $id, $quantityId) {
        $this->setModel(new ProductQuantity);
        $productQuantity = parent::getEntity($quantityId);
        return view('admin::product.product-quantity', ['productQuantity' => $productQuantity]);
    }
    
    public function updateProductQuantity(Request $request, $id, $quantityId) {
        $this->setModel(new ProductQuantity);
        $redirect = redirect()->route('admin::view.product.quantity', ['id' => $id, 'quantityId' => $quantityId]);
        parent::updateEntity($request->all(), $quantityId, $redirect);
        return $redirect->with('status', 'Product quantity updated!');
    }
    
    public function deleteProductQuantity(Request $request, $id, $quantityId) {
        $this->setModel(new ProductQuantity);
        parent::deleteEntity($quantityId);
        return redirect()->route('admin::view.product', ['id' => $id])
                ->with('status', 'Product quantity deleted!');
    }
    
    public function newProductMaterialQuantity(Request $request, $id) {
        $this->setModel(new ProductMaterial);
        $productMaterial = parent::getEntity($id);
        return view('admin::product.product-material-quantity.new', [
            'productMaterial' => $productMaterial,
            'quantities' => ProductQuantity::where('product_id', $productMaterial->product_id)->whereNotIn('id', $productMaterial->quantities->pluck('product_quantity_id')->all())->get()
        ]);
    }
    
    public function storeProductMaterialQuantity(Request $request, $id) {
        $this->setModel(new ProductMaterial);
        $productMaterial = parent::getEntity($id);
        $this->setModel(new ProductMaterialQuantity);
        $redirect = redirect()->route('admin::new.product.material.quantity', ['id' => $productMaterial->id]);
        $request->merge(['product_material_id' => $productMaterial->id]);
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.product.material', ['id' => $productMaterial->product_id, 'materialId' => $productMaterial->material_id])
                ->with('status', 'Product material quantity added!');
    }
    
    public function showProductMaterialQuantity(Request $request, $id, $quantityId) {
        $this->setModel(new ProductMaterialQuantity);
        $productMaterialQuantity = parent::getEntityByFields([
            ['column' => 'product_material_id', 'condition' => '=', 'value' => $id],
            ['column' => 'product_quantity_id', 'condition' => '=', 'value' => $quantityId],
        ]);
        $productMaterial = $productMaterialQuantity->material;
        $productQuantityIdKey = null;
        $productQuantityIds = $productMaterial->quantities->pluck('product_quantity_id')->all();
        foreach ($productQuantityIds as $key => $value) {
            if ($value == $quantityId) {
                $productQuantityIdKey = $key;
            }
        }
        array_forget($productQuantityIds, $productQuantityIdKey);
        return view('admin::product.product-material-quantity.view', [
            'productMaterialQuantity' => $productMaterialQuantity,
            'productMaterial' => $productMaterial,
            'quantities' => ProductQuantity::where('product_id', $productMaterial->product_id)->whereNotIn('id', is_null($productQuantityIds) ? [] : $productQuantityIds)->get()
        ]);
    }
    
    public function updateProductMaterialQuantity(Request $request, $id, $quantityId) {
        $this->setModel(new ProductMaterialQuantity);
        $redirect = redirect()->route('admin::view.product.material.quantity', ['id' => $id, 'quantityId' => $quantityId]);
        parent::updateEntityByFields($request->all(), [
            ['column' => 'product_material_id', 'condition' => '=', 'value' => $id],
            ['column' => 'product_quantity_id', 'condition' => '=', 'value' => $quantityId],
        ], $redirect);
        return redirect()->route('admin::view.product.material.quantity', ['id' => $id, 'quantityId' => $request->input('product_quantity_id')])
                ->with('status', 'Product material quantity updated!');
    }
    
    public function deleteProductMaterialQuantity(Request $request, $id, $quantityId) {
        $this->setModel(new ProductMaterial);
        $productMaterial = parent::getEntity($id);
        $this->setModel(new ProductMaterialQuantity);
        parent::deleteEntityByFields([
            ['column' => 'product_material_id', 'condition' => '=', 'value' => $id],
            ['column' => 'product_quantity_id', 'condition' => '=', 'value' => $quantityId],
        ]);
        return redirect()->route('admin::view.product.material', ['id' => $productMaterial->product_id, 'materialId' => $productMaterial->material_id])
                ->with('status', 'Product material quantity added!');
    }

}
