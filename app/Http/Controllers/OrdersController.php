<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Order;
use App\Models\OrderFeedback;
use App\Models\Sale;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Order);
    }

    public function index()
    {
        $this->setLimit(5);
        $user = getAuthenticatedUser();
        return view('orders.index', [
            'user' => $user,
            'orders' => parent::getEntitiesWithPagination([
                ['column' => 'user_id', 'condition' => '=', 'value' => $user->id],
                ['column' => 'disabled', 'condition' => '=', 'value' => 0]
            ], ['column' => 'created_at', 'type' => 'DESC']),
            'popularDesigns' => Design::getPopularDesigns(),
            'recommendedDesigns' => Design::getRecommendedDesigns(8)
        ]);
    }

    public function showSales()
    {
        $this->setModel(new Sale);
        $user = getAuthenticatedUser();

        return view('orders.sales', [
            'monthTotal' => $this->model->getTotalAmountOfCommissionsForMonth($user),
            'lastMonthTotal' => $this->model->getTotalAmountOfCommissionsForLastMonth($user),
            'totalCommissions' => $this->model->getTotalAmountOfCommissions($user),
            'user' => $user,
            'sales' => parent::getEntitiesWithPagination([
                ['column' => 'user_id', 'condition' => '=', 'value' => $user->id]
            ], ['column' => 'created_at', 'type' => 'DESC']),
            'recommendedDesigns' => Design::getRecommendedDesigns(8)
        ]);
    }

    public function printOrder($friendlyId)
    {
        $order = parent::getEntityByFields([
            ['column' => 'friendly_id', 'condition' => '=', 'value' => $friendlyId],
            ['column' => 'user_id', 'condition' => '=', 'value' => getAuthenticatedUser()->id],
            ['column' => 'disabled', 'condition' => '=', 'value' => 0]
        ]);

        return view('orders.print', [
            'order' => $order,
            'user' => $order->user,
            'barcode' => $order->getBarcode(),
        ]);
    }

    public function storeOrderFeedback(Request $request, $id)
    {
        $order = parent::getEntity($id);
        $this->setModel(new OrderFeedback);
        $redirect = redirect()->route('view.orders');
        $request->merge(['order_id' => $order->id]);
        parent::storeEntity($request->all(), $redirect);
        return $redirect->with('status', 'Feedback submitted successfully!');
    }
}
