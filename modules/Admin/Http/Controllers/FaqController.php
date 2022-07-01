<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqCategory;
use App\Models\Faq;

class FaqController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->setModel(new Faq);
    }
    
    public function showFaqCategories(Request $request) {
        $this->setModel(new FaqCategory);
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $categories = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::faq.faq-category-row', ['categories' => $categories]);
        }
        return view('admin::faq.faq-categories', [
            'categories' => $categories,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function newFaqCategory(Request $request) {
        $this->setModel(new FaqCategory);
        return view('admin::faq.new-faq-category');
    }
    
    public function storeFaqCategory(Request $request) {
        $this->setModel(new FaqCategory);
        $redirect = redirect()->route('admin::new.faq.category');
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.faq.category', ['id' => $entity->id])
                ->with('status', 'FAQ Category created!');
    }
    
    public function showFaqCategory(Request $request, $id) {
        $this->setModel(new FaqCategory);
        return view('admin::faq.faq-category', ['category' => parent::getEntity($id)]);
    }
    
    public function updateFaqCategory(Request $request, $id) {
        $this->setModel(new FaqCategory);
        $redirect = redirect()->route('admin::view.faq.category', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'FAQ Category updated!');
    }
    
    public function deleteFaqCategory(Request $request, $id) {
        $this->setModel(new FaqCategory);
        parent::deleteEntity($id);
        return redirect()->route('admin::view.faq.categories')
                ->with('status', 'FAQ Category deleted!');
    }
    
    public function showFaqs(Request $request) {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $faqs = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::faq.faq-row', ['faqs' => $faqs]);
        }
        return view('admin::faq.faqs', [
            'faqs' => $faqs,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function newFaq(Request $request) {
        return view('admin::faq.new-faq', ['categories' => FaqCategory::all()]);
    }
    
    public function storeFaq(Request $request) {
        $redirect = redirect()->route('admin::new.faq');
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.faq', ['id' => $entity->id])
                ->with('status', 'FAQ created!');
    }
    
    public function showFaq(Request $request, $id) {
        return view('admin::faq.faq', [
            'faq' => parent::getEntity($id),
            'categories' => FaqCategory::all()
        ]);
    }
    
    public function updateFaq(Request $request, $id) {
        $redirect = redirect()->route('admin::view.faq', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'FAQ updated!');
    }
    
    public function deleteFaq(Request $request, $id) {
        parent::deleteEntity($id);
        return redirect()->route('admin::view.faqs')
                ->with('status', 'FAQ deleted!');
    }

}
