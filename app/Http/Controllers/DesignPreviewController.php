<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Design;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DesignPreviewController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function show(Request $request)
    {
        $designImages = $request->has('design_id')
            ? Design::findOrFail($request->get('design_id'))->getDesignImages()
            : session('designImages');

        return view('design.design-preview', [
            'designImages' => $designImages,
            'products' => Product::all(),
            'materials' => Material::all(),
        ]);
    }

    /**
     * @param $basketId
     * @return View
     */
    public function edit($basketId)
    {
        return view('design.design-preview', [
            'designImages' => Basket::find($basketId)->design_images,
            'products' => Product::all(),
            'materials' => Material::all(),
        ]);
    }
}
