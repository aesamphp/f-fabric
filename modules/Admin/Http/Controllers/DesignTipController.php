<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DesignTipCategory;
use App\Models\DesignTip;

class DesignTipController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->setModel(new DesignTip);
    }
    
    public function showDesignTipCategories(Request $request) {
        $this->setModel(new DesignTipCategory);
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $categories = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::design-tip.design-tip-category-row', ['categories' => $categories]);
        }
        return view('admin::design-tip.design-tip-categories', [
            'categories' => $categories,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function newDesignTipCategory(Request $request) {
        $this->setModel(new DesignTipCategory);
        return view('admin::design-tip.new-design-tip-category');
    }
    
    public function storeDesignTipCategory(Request $request) {
        $this->setModel(new DesignTipCategory);
        $redirect = redirect()->route('admin::new.design.tip.category');
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.design.tip.category', ['id' => $entity->id])
                ->with('status', 'Design Tip Category created!');
    }
    
    public function showDesignTipCategory(Request $request, $id) {
        $this->setModel(new DesignTipCategory);
        return view('admin::design-tip.design-tip-category', ['category' => parent::getEntity($id)]);
    }
    
    public function updateDesignTipCategory(Request $request, $id) {
        $this->setModel(new DesignTipCategory);
        $redirect = redirect()->route('admin::view.design.tip.category', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Design Tip Category updated!');
    }
    
    public function deleteDesignTipCategory(Request $request, $id) {
        $this->setModel(new DesignTipCategory);
        parent::deleteEntity($id);
        return redirect()->route('admin::view.design.tip.categories')
                ->with('status', 'Design Tip Category deleted!');
    }

    public function showDesignTips(Request $request) {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $designTips = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::design-tip.design-tip-row', ['designTips' => $designTips]);
        }
        return view('admin::design-tip.design-tips', [
            'designTips' => $designTips,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function newDesignTip(Request $request) {
        return view('admin::design-tip.new-design-tip', ['categories' => DesignTipCategory::all()]);
    }
    
    public function storeDesignTip(Request $request) {
        $redirect = redirect()->route('admin::new.design.tip');
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.design.tip', ['id' => $entity->id])
                ->with('status', 'Design Tip created!');
    }
    
    public function showDesignTip(Request $request, $id) {
        return view('admin::design-tip.design-tip', [
            'designTip' => parent::getEntity($id),
            'categories' => DesignTipCategory::all()
        ]);
    }
    
    public function updateDesignTip(Request $request, $id) {
        $redirect = redirect()->route('admin::view.design.tip', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Design Tip updated!');
    }
    
    public function deleteDesignTip(Request $request, $id) {
        parent::deleteEntity($id);
        return redirect()->route('admin::view.design.tips')
                ->with('status', 'Design Tip deleted!');
    }

}
