<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Design;
use App\Models\DesignColour;
use App\Models\DesignLabel;
use App\Models\Material;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Category);
    }

    public function index()
    {
        return view('shop.index', ['categories' => Category::getShoppableCategories()]);
    }

    public function showAll(Request $request)
    {
        $this->setLimit(28);

        if (!$request->has('filter')) {
            $request->merge(['filter' => 'new']);
        }

        if (!$request->has('availability')) {
            $request->merge(['availability' => 'sale']);
        }

        $category       = $this->getModel();
        $categoryFilter = ($request->has('category')) ? $request->get('category') : 'all';
        $filter         = $request->get('filter');
        $availability   = $request->get('availability');
        $keyword        = $request->get('keyword');
        $filterLabels   = ($request->has('labels')) ? $request->get('labels') : [];
        $filterColours  = ($request->has('colours')) ? $request->get('colours') : [];
        $appends        = ['category' => $categoryFilter, 'filter' => $filter, 'availability' => $availability, 'labels' => $filterLabels, 'keyword' => $keyword, 'colours' => $filterColours];
        $viewFile       = ($request->ajax()) ? 'shop.category-form-content' : 'shop.category';

        return view($viewFile, [
            'categoryFilter' => $categoryFilter,
            'categories' => Category::getShoppableCategories(),
            'category' => $category,
            'labelCollection' => DesignLabel::getPopularLabels(),
            'coloursCollection' => DesignColour::getColourPalettes(),
            'filter' => $filter,
            'keyword' => $keyword,
            'filterLabels' => $filterLabels,
            'filterColours' => $filterColours,
            'availability' => $availability,
            'appends' => $appends,
            'designs' => $this->getPaginateDesigns($request)
        ]);
    }

    public function shopPagination(Request $request)
    {
        $this->setLimit(28);

        if (!$request->has('filter')) {
            $request->merge(['filter' => 'new']);
        }

        if (!$request->has('availability')) {
            $request->merge(['availability' => 'sale']);
        }

        $designs = $this->getPaginateDesigns($request);

        return response()->json([
            'count' => $designs->total(),
            'html' => view('shop.pagination', [
                'designs' => $designs,
                'categoryFilter' => $request->has('category') ? $request->get('category') : 'all'
            ])->render()
        ]);
    }

    public function showDesign(Request $request, $designIdentifier)
    {
        $this->setModel(new Design);
        $design = parent::getEntityByIdentifier($designIdentifier, [
            ['column' => 'swatch_purchased', 'condition' => '=', 'value' => 1],
            ['column' => 'public', 'condition' => '=', 'value' => 1],
            ['column' => 'approved', 'condition' => '=', 'value' => 1],
            ['column' => 'dispatch_approved', 'condition' => '=', 'value' => 1],
            ['column' => 'disabled', 'condition' => '=', 'value' => 0]
        ]);
        return view('shop.design', [
            'design' => $design,
            'designImages' => $design->getDesignImages(),
            'categories' => Category::getShoppableCategories(),
            'categoryFilter' => is_numeric($request->get('category')) ? $request->get('category') : 1,
            'products' => Product::all(),
            'materials' => Material::all(),
            'latestDesigns' => Design::getLatestDesigns(3)
        ]);
    }

    public function showSampleBooks()
    {
        return view('shop.sample-books', ['category' => parent::getEntity(6)]);
    }

    public function showColourAtlas()
    {
        return view('shop.colour-atlas', ['category' => parent::getEntity(5)]);
    }

    public function showPlainFabrics()
    {
        return view('shop.plain-fabrics', ['category' => parent::getEntity(7)]);
    }

    private function getPaginateDesigns($request)
    {
        $query = $this->buildDesignsQuery();
        if ($request->has('category')) {
            $query = $this->handleCategoryFilters($query, $request->get('category'));
        }
        if ($request->has('availability')) {
            $query = $this->applyAvailabilityCondition($query, $request->get('availability'));
        }
        if ($request->has('keyword')) {
            $query = $this->applyKeywordCondition($query, '%' . $request->input('keyword') . '%');
        }
        if ($request->has('filter')) {
            $query = $this->applyFilterCondition($query, $request->get('filter'));
        }
        if ($request->has('labels')) {
            $query = $this->applyFilterLabelsCondition($query, $request->get('labels'));
        }
        if ($request->has('colours')) {
            $query = $this->applyColoursCondition($query, $request->get('colours'));
        }
        return $query->groupBy('designs.id')
            ->distinct()
            ->paginate($this->getLimit());
    }

    private function buildDesignsQuery()
    {
        return Design::select('designs.*')
            ->where('designs.private', 0)
            ->where('designs.approved', 1)
            ->where('designs.disabled', 0)
            ->whereNull('designs.deleted_at');
    }

    private function handleCategoryFilters($query, $category)
    {
        if ($category !== 'all') {
            $query->join('design_categories', 'designs.id', '=', 'design_categories.design_id')
                ->where('design_categories.category_id', $category)
                ->whereNull('design_categories.deleted_at');
        }
        return $query;
    }

    private function applyAvailabilityCondition($query, $availability)
    {
        if ($availability === 'sale') {
            $query->where('designs.public', 1)
                ->where('designs.dispatch_approved', 1);
        } elseif ($availability === 'not-for-sale') {
            $query->where('designs.public', 0);
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

    private function applyKeywordCondition($query, $keyword)
    {
        return $query->join('users', 'users.id', '=', 'designs.user_id')
            ->where(function ($query) use ($keyword) {
                $query->where('designs.title', 'like', $keyword)
                    ->orWhere('designs.description', 'like', $keyword)
                    ->orWhere('designs.additional_details', 'like', $keyword)
                    ->orWhere('users.username', 'like', $keyword);
            });
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

    private function applyColoursCondition($query, $filterColours)
    {
        $array = [];
        foreach ($filterColours as $colour) {
            foreach (explode(',', $colour) as $value) {
                $array[] = '#' . $value;
            }
        }
        return $query->join('design_colours', 'designs.id', '=', 'design_colours.design_id')
            ->whereIn('design_colours.value', $array)
            ->whereNull('design_colours.deleted_at');
    }

}
