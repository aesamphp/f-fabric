<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
use Illuminate\View\View;

class DesignManipulateController extends Controller
{
    /**
     * @return View
     */
    public function create()
    {
        $designImages = session('designImages');
        $designImagesDpi = session('designImagesDpi');

        if (!$designImages) {
            return redirect()->route('view.design.upload')->withError('The file is required.');
        }

        return view('design.manipulate', [
            'designImages' => $designImages,
            'designImagesDpi' => $designImagesDpi,
            'categories' => Category::getShoppableCategories(),
            'products' => Product::all(),
            'materials' => Material::all(),
        ]);
    }

    /**
     * @param null $id
     * @return View
     */
    public function edit($id)
    {
        $basket = Basket::find($id);

        if (!$basket) {
            return redirect()->route('view.design.upload')->withError('The file is required.');
        }

        return view('design.manipulate', [
            'designImages' => $basket->design_images,
            'categories' => Category::getShoppableCategories(),
            'products' => Product::all(),
            'materials' => Material::all(),
            'basket' => $basket,
        ]);
    }
}
