<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Design;
use App\Services\BucksNetService;
use Validator;

class SaleController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->setModel(new Sale);
    }

    public function showCommissions(Request $request) {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $searchKeyword = ($request->has('search_keyword')) ? $request->get('search_keyword') : null;
        $commissions = $searchKeyword ? $this->searchSales($searchKeyword, $offset) : parent::getEntities($offset, [], ['column' => 'created_at', 'type' => 'desc']);
        if ($request->ajax()) {
            return view('admin::sale.commission-row', ['commissions' => $commissions]);
        }
        return view('admin::sale.commissions', [
            'searchKeyword' => $searchKeyword,
            'commissions' => $commissions,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function newCommission(Request $request) {
        return view('admin::sale.new-commission', ['typeOptions' => Sale::getTypeOptions()]);
    }
    
    public function storeCommission(Request $request) {
        $model = parent::getModel();
        $redirect = redirect()->route('admin::new.commission');
        $validator = Validator::make($request->all(), $model->createByAdminRules(), $model->messages());
        if ($validator->fails()) {
            return $redirect->withErrors($validator)
                    ->withInput();
        }
        $commission = $this->createNewCommission($request, $redirect);
        if (!isset($commission->id)) {
            return $commission;
        }
        $this->sendNewCommissionEmail($commission);
        return redirect()->route('admin::view.commissions')
                ->with('status', 'Commission created!');
    }
    
    public function payCommission(Request $request, $id) {
        $commission = parent::getEntityByFields([
            ['column' => 'id', 'condition' => '=', 'value' => $id],
            ['column' => 'paid', 'condition' => '=', 'value' => 0]
        ]);
        $redirect = redirect()->route('admin::view.commissions');
        $commission->update(['tax' => $commission->calculateTaxAmount()]);
        $bucksnet = $this->handleBucksnetAccountAddInstruction($commission);
        if ($bucksnet->fails()) {
            return $redirect->with('error', $bucksnet->getResponse());
        }
        $commission->paid = 1;
        $commission->update();
        return $redirect->with('status', 'Commission paid successfully!');
    }
    
    public function downloadCommissions(Request $request) {
        $redirect = redirect()->route('admin::view.commissions');
        return parent::downloadCSV($request->all(), $redirect);
    }
    
    public function updateCommissionsStatus(Request $request) {
        $status = $request->has('status') ? $request->input('status') : null;
        $saleIds = $request->has('sales') ? $request->input('sales') : [];
        $redirect = redirect()->route('admin::view.commissions');
        if ($status === 'paid' && is_array($saleIds) && !empty($saleIds)) {
            Sale::whereIn('id', $saleIds)->update(['paid' => 1]);
            $commissions = Sale::whereIn('id', $saleIds)->get();
            $redirect->with('status', 'Commission paid successfully!');
        }
        return $redirect;
    }
    
    private function searchSales($keyword, $offset) {
        $model = parent::getModel();
        return $model::select('sales.*')
                ->join('users', 'sales.user_id', '=', 'users.id')
                ->join('order_items', 'sales.order_item_id', '=', 'order_items.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where(function ($query) use ($keyword) {
                    $query->where('orders.friendly_id', 'like', '%' . $keyword . '%')
                            ->orWhere('users.friendly_id', 'like', '%' . $keyword . '%')
                            ->orWhere('users.first_name', 'like', '%' . $keyword . '%')
                            ->orWhere('users.last_name', 'like', '%' . $keyword . '%');
                })
                ->orderBy('sales.created_at', 'DESC')
                ->take($this->getLimit())
                ->skip($offset)
                ->get();
    }
    
    private function handleBucksnetAccountAddInstruction($commission) {
        $bucksnet = new BucksNetService;
        $bucksnet->MakeRequest(BucksNetService::ACTION_ACCOUNT_ADD_INSTRUCTION, [
            'AccountReference' => $commission->user->paymentDetail->bucksnet_id,
            'TransactionCode' => '99',
            'Amount' => $commission->getTotalAmount(),
            'Date' => date('c')
        ]);
        return $bucksnet;
    }
    
    private function createNewCommission($request, $redirect) {
        $userKeyword = $request->input('user_friendly_id');
        $user = User::where(function ($query) use ($userKeyword) {
                    $query->where('friendly_id', $userKeyword)
                            ->orWhere('username', $userKeyword)
                            ->orWhere('email', $userKeyword);
                })
                ->where('disabled', 0)
                ->firstOrFail();
        $order = Order::where('friendly_id', $request->input('order_friendly_id'))->where('disabled', 0)->firstOrFail();
        $design = Design::where('friendly_id', $request->input('design_friendly_id'))->where('user_id', $user->id)->where('disabled', 0)->firstOrFail();
        $orderItem = OrderItem::where('order_id', $order->id)->where('design_id', $design->id)->firstOrFail();
        return parent::storeEntity([
            'user_id' => $user->id,
            'order_item_id' => $orderItem->id,
            'type_id' => $request->input('type_id'),
            'amount' => $request->input('amount')
        ], $redirect);
    }
    
    private function sendNewCommissionEmail($commission) {
        parent::sendEmail('emails.sale', ['sale' => $commission], [
            'from_email' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
            'to_email' => $commission->user->email,
            'to_name' => $commission->user->getFullName(),
            'subject' => 'You Made A Sale'
        ]);
    }

}
