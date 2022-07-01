<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Design;
use App\Models\DesignLabel;
use App\Models\Studio;
use DB;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Studio);
    }

    public function showDesignerStore(Request $request, $username)
    {
        $this->setLimit(28);
        $store = parent::getEntityByFields([
            ['column' => 'username', 'condition' => '=', 'value' => $username],
            ['column' => 'public', 'condition' => '=', 'value' => 1],
            ['column' => 'disabled', 'condition' => '=', 'value' => 0]
        ]);

        $designer        = $store->user;
        $categoryFilters = ($request->get('category')) ? $request->get('category') : [];
        $filterLabels    = ($request->has('labels')) ? $request->get('labels') : [];
        $arrange         = ($request->get('arrange')) ? $request->get('arrange') : 'ASC';
        $filter          = $request->get('filter');
        $appends         = ['category' => $categoryFilters, 'filter' => $filter, 'labels' => $filterLabels, 'arrange' => $arrange];
        $viewFile        = ($request->ajax()) ? 'store.designer-store-form-content' : 'store.designer-store';

        return view($viewFile, [
            'categories' => Category::getShoppableCategories(),
            'store' => $store,
            'designer' => $designer,
            'categoryFilters' => $categoryFilters,
            'filterLabels' => $filterLabels,
            'arrange' => $arrange,
            'filter' => $filter,
            'appends' => $appends,
            'labelCollection' => DesignLabel::getPopularLabels(),
            'designs' => $this->getPaginateDesigns($request, $designer)
        ]);
    }

    public function studioPagination(Request $request, $username)
    {
        $this->setLimit(28);

        if (!$request->has('filter')) {
            $request->merge(['filter' => 'new']);
        }

        if (!$request->has('availability')) {
            $request->merge(['availability' => 'sale']);
        }

        $store = parent::getEntityByFields([
            ['column' => 'username', 'condition' => '=', 'value' => $username],
            ['column' => 'public', 'condition' => '=', 'value' => 1],
            ['column' => 'disabled', 'condition' => '=', 'value' => 0]
        ]);

        $designer = $store->user;
        $designs  = $this->getPaginateDesigns($request, $designer);

        return response()->json([
            'count' => $designs->total(),
            'html' => view('store.designer-store-form-content', [
                'designs' => $designs,
                'designer' => $store->user,
                'categoryFilter' => $request->has('category') ? $request->get('category') : 'all',
            ])->render()
        ]);
    }

    private function getPaginateDesigns(Request $request, $designer)
    {
        $query = Design::select('designs.*')
            ->where('designs.user_id', $designer->id)
            ->where('designs.private', 0)
            ->where('designs.approved', 1)
            ->where('designs.disabled', 0)
            ->whereNull('designs.deleted_at');

        if ($request->has('category')) {
            $query = $this->handleCategoryFilters($query, $request->get('category'));
        }

        if ($request->has('filter')) {
            $query = $this->applyFilterCondition($query, $request->get('filter'));
        }

        if ($request->has('labels')) {
            $query = $this->applyFilterLabelsCondition($query, $request->get('labels'));
        }

        return $query->orderBy('designs.title', $request->get('arrange'))
            ->groupBy('designs.id')
            ->distinct()
            ->paginate($this->getLimit());
    }

    private function handleCategoryFilters($query, $category)
    {
        if ('all' !== $category) {
            $categoryIds = [];
            foreach ($category as $value) {
                if (is_numeric($value)) {
                    $categoryIds[] = $value;
                }
            }
            $query = $this->applyCategoryFilters($query, $category, $categoryIds);
        }
        return $query;
    }

    private function applyCategoryFilters($query, $category, $categoryIds)
    {
        if (in_array('not-for-sale', $category)) {
            $query->where('designs.public', 0);
        } else {
            $query->where('designs.public', 1);
        }
        if (!empty($categoryIds)) {
            $query->join('design_categories', 'designs.id', '=', 'design_categories.design_id')
                ->whereIn('design_categories.category_id', $categoryIds)
                ->whereNull('design_categories.deleted_at');
        }
        return $query;
    }

    private function applyFilterCondition($query, $filter)
    {
        if ($filter === 'most-popular') {
            $query->leftJoin('favourite_designs', 'designs.id', '=', 'favourite_designs.design_id')
                ->addSelect(DB::raw('favourite_designs.design_id, COUNT(favourite_designs.design_id) as favourite_count'))
                ->whereNull('favourite_designs.deleted_at')
                ->groupBy('favourite_designs.design_id')
                ->orderBy('favourite_count', 'DESC');
        } elseif ($filter === 'best-seller') {
            $query->leftJoin('order_items', 'designs.id', '=', 'order_items.design_id')
                ->addSelect(DB::raw('order_items.design_id, COUNT(order_items.design_id) as sales_count'))
                ->whereNull('order_items.deleted_at')
                ->groupBy('order_items.design_id')
                ->orderBy('sales_count', 'DESC');
        } else {
            $query->orderBy('designs.created_at', 'DESC');
        }
        return $query;
    }

    private function applyFilterLabelsCondition($query, $filterLabels)
    {
        $query->join('design_labels', 'designs.id', '=', 'design_labels.design_id')
            ->where(function ($query) use ($filterLabels) {
                foreach ($filterLabels as $key => $label) {
                    if ($key === 0) {
                        $query->where('design_labels.title', $label);
                    } else {
                        $query->orWhere('design_labels.title', $label);
                    }
                }
            });
        return $query->whereNull('design_labels.deleted_at');
    }

}
