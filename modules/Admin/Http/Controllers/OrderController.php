<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\XmlFileGenerator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Order);
    }

    public function showOrders(Request $request)
    {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $searchKeyword = ($request->has('search_keyword')) ? $request->get('search_keyword') : null;
        $sort_by = ($request->has('sort_by')) ? $request->input('sort_by') : 'new';
        $orderBy = ['column' => 'created_at', 'type' => 'DESC'];
        if ($sort_by === 'status') {
            $orderBy = ['column' => 'dispatched', 'type' => 'ASC'];
        }
        $orders = $searchKeyword ? $this->searchOrders($searchKeyword, $offset) : parent::getEntities($offset, [
            ['column' => 'disabled', 'condition' => '=', 'value' => 0],
        ], $orderBy);

        if ($request->ajax()) {
            return view('admin::order.order-row', ['orders' => $orders]);
        }

        return view('admin::order.orders', [
            'searchKeyword' => $searchKeyword,
            'orders' => $orders,
            'sort_by' => $sort_by,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount(),
        ]);
    }

    public function showOrder(Request $request, $id)
    {
        return view('admin::order.order', ['order' => parent::getEntity($id)]);
    }

    public function deleteOrder(Request $request, $id)
    {
        parent::deleteEntity($id);

        return redirect()->route('admin::view.orders')
            ->with('status', 'Order deleted!');
    }

    public function dispatchOrder(Request $request, $id)
    {
        $order = parent::getEntity($id);
        $redirect = redirect()->route('admin::view.order', ['id' => $order->id]);
        parent::updateEntity($request->all(), $id, $redirect);
        foreach ($order->orderItems as $item) {
            if ($item->isDesign()) {
                $item->design->dispatch_approved = 1;
                $item->design->update();
            }
        }
        $this->sendOrderDispatchEmail($order);

        return $redirect->with('status', 'Order dispatched!');
    }

    public function downloadOrders(Request $request)
    {
        $this->setModel(new OrderItem);
        $redirect = redirect()->route('admin::view.orders');

        return parent::downloadCSV($request->all(), $redirect, true);
    }

    public function printOrder($id)
    {
        $order = Order::find($id);

        return view('orders.print',
            [
                'order' => $order,
                'user' => $order->user,
                'barcode' => $order->getBarcode(),
            ]
        );
    }

    public function downloadDesignFile(Request $request, $id, $itemId)
    {
        $this->setModel(new OrderItem);
        $orderItem = parent::getEntityByFields([
            ['column' => 'id', 'condition' => '=', 'value' => $itemId],
            ['column' => 'order_id', 'condition' => '=', 'value' => $id],
        ]);
        $filePath = $orderItem->design->getImagePath(getDesignImageType('TYPE_ORIGINAL'));

        return response()->download(public_path($filePath), $orderItem->getDownloadDesignFileName($filePath));
    }

    public function downloadOrderXML(Request $request, $id)
    {
        $order = parent::getEntity($id);
        $xmlFileName = $order->getXMLFilePath();
        if (!file_exists($xmlFileName)) {
            $xmlFile = new XmlFileGenerator($order->getXMLFilePath(), $order->buildXMLElementsArray());
            $xmlFile->generate();
        }

        return response()->download(public_path($xmlFileName));
    }

    private function sendOrderDispatchEmail($order)
    {
        parent::sendEmail('emails.order-dispatch', ['order' => $order], [
            'from_email' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
            'to_email' => $order->user->email,
            'to_name' => $order->user->getFullName(),
            'subject' => 'You Order is Dispatched',
        ]);
    }

    private function searchOrders($keyword, $offset)
    {
        $model = parent::getModel();

        return $model::select('orders.*')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where(function ($query) use ($keyword) {
                $query->where('orders.friendly_id', 'like', '%' . $keyword . '%')
                    ->orWhere('users.friendly_id', 'like', '%' . $keyword . '%')
                    ->orWhere('users.first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('users.last_name', 'like', '%' . $keyword . '%');
            })
            ->orderBy('orders.created_at', 'DESC')
            ->take($this->getLimit())
            ->skip($offset)
            ->get();
    }
}
