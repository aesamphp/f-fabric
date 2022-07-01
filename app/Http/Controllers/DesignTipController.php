<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\DesignTipCategory;
use App\Models\DesignTip;

class DesignTipController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->setModel(new DesignTip);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category = null) {
        $this->setModel(new DesignTipCategory);
        if ($category === null) {
            $designTipCategory = null;
            $designTips = DesignTip::all();
        } else {
            $designTipCategory = parent::getEntityByIdentifier($category);
            $designTips = $designTipCategory->designTips;
        }
        $viewFile = ($request->ajax()) ? 'design-tip.questions' : 'design-tip.index';
        return view($viewFile, [
            'categories' => parent::getAllEntities(),
            'category' => $designTipCategory,
            'designTips' => $designTips
        ]);
    }
    
    public function search(Request $request) {
        if (!$request->has('keyword')) {
            return response('The keyword field is required.', Response::HTTP_BAD_REQUEST);
        }
        $this->setModel(new DesignTipCategory);
        $keyword = '%' . $request->input('keyword') . '%';
        $viewFile = ($request->ajax()) ? 'design-tip.search-questions' : 'design-tip.search';
        return view($viewFile, [
            'keyword' => $request->input('keyword'),
            'categories' => parent::getAllEntities(),
            'searchCategories' => parent::getModel()->searchDesignTips($keyword)
        ]);
    }
    
    public function showDesignTip(Request $request, $category, $identifier) {
        $viewFile = ($request->ajax()) ? 'design-tip.answer' : 'design-tip.view';
        return view($viewFile, [
            'designTip' => parent::getEntityByIdentifier($identifier),
            'categories' => DesignTipCategory::all()
        ]);
    }

}
