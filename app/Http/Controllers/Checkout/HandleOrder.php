<?php

namespace App\Http\Controllers\Checkout;

use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderBillingAddress;
use App\Models\OrderShippingAddress;
use App\Models\DiscountCodeUsed;
use App\Models\Sale;
use App\Models\Product;
use App\Models\EmailTemplateAction;
use DbView;

trait HandleOrder {

    protected function createOrder($data) {
        $this->setModel(new Order);
        $redirect = redirect()->route('view.checkout.order.review');
        $newData = [];
        foreach ($data as $key => $value) {
            $newData[camel_case($key)] = $value;
        }
        $newData['actual_amount'] = $newData['amount'];
        $newData['amount'] = Basket::getBasketGrandTotal();
        $newData['currency'] = getCurrentCurrency()->code;
        $newData['vat'] = Basket::getBasketVat();
        $newData['surcharge'] = (isset($newData['surcharge'])) ? convertPriceToCurrentCurrency($newData['surcharge']) : 0;
        $order = parent::storeEntity($newData, $redirect);
        $this->createOrderItems($order, $redirect);
        $this->createOrderAddresses($order, $redirect);
        if (isDiscountApplied()) {
            $this->applyOrderDiscount($order, $redirect);
        }
        return $order;
    }
    
    protected function createOrderItems($order, $redirect) {
        $basket = Basket::getBasketItems();
        foreach ($basket as $item) {
            $data = [
                'order_id' => $order->id,
                'design_id' => $item->design_id,
                'category_id' => $item->category_id,
                'product_id' => $item->product_id,
                'material_id' => $item->material_id,
                'repeat_type' => $item->design_type_id,
                'dpi' => $item->dpi,
                'quantity' => $item->quantity,
                'unit_price' => $item->gross_price,
                'product_weight' => $item->product->getWeight($item->material_id)
            ];
            $this->setModel(new OrderItem);
            $orderItem = parent::storeEntity($data, $redirect);
            if (Basket::isDesign($item) && !$item->design->isOwner(getAuthenticatedUser()->id)) {
                $this->createSale($orderItem, $item, $redirect);
            }
        }
    }
    
    protected function createSale($orderItem, $basketItem, $redirect) {
        $this->setModel(new Sale);
        $data = [
            'user_id' => $orderItem->design->user_id,
            'order_item_id' => $orderItem->id,
            'type_id' => Sale::TYPE_SALE,
            'amount' => calculateSaleCommission($basketItem->gross_total)
        ];
        $sale = parent::storeEntity($data, $redirect);
        parent::sendEmail('emails.sale', ['sale' => $sale], [
            'from_email' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
            'to_email' => $sale->user->email,
            'to_name' => $sale->user->getFullName(),
            'subject' => 'You Made A Sale'
        ]);
    }
    
    protected function createOrderAddresses($order, $redirect) {
        $this->setModel(new OrderBillingAddress);
        $billingAddress = (array)session()->get('checkoutBillingAddress');
        $billingAddress['order_id'] = $order->id;
        parent::storeEntity($billingAddress, $redirect);
        $this->setModel(new OrderShippingAddress);
        $deliveryAddress = (array)session()->get('checkoutDeliveryAddress');
        $deliveryAddress['order_id'] = $order->id;
        $deliveryAddress['price'] = getShippingNetPrice();
        parent::storeEntity($deliveryAddress, $redirect);
    }
    
    protected function applyOrderDiscount($order, $redirect) {
        $this->setModel(new DiscountCodeUsed);
        $data = [
            'discount_id' => getAppliedDiscountCode()->id,
            'order_id' => $order->id,
            'amount' => getDiscountAmount()
        ];
        parent::storeEntity($data, $redirect);
    }

    protected function sendOrderEmail($order, $orderNotifications) {
        //$emailTemplate = getEmailTemplate(EmailTemplateAction::ACTION_NEW_ORDER_CUSTOMER_NOTIFICATION);
        $view = 'emails.new-order-customer-notification';
        $data = ['order' => $order, 'user' => $order->user];
        $headers = ['from_email' => config('mail.from.address'), 'from_name' => config('mail.from.name'), 'to_email' => $order->user->email, 'to_name' => $order->user->getFullName(), 'subject' => 'New Order'];
        /*if ($emailTemplate) {
            $view = 'emails.template';
            $data = ['template' => DbView::make($emailTemplate)->with($data)->render()];
            $headers['subject'] = $emailTemplate->subject;
        }*/
        if ($orderNotifications->email_notification) {
            parent::sendEmail($view, $data, $headers);
        }
        $this->sendOtherPersonOrderEmail($view, $data, $headers, $orderNotifications);
        $this->sendAdminOrderEmail($view, $data, $headers);
    }
    
    protected function sendOtherPersonOrderEmail($view, $data, $headers, $orderNotifications) {
        if ($orderNotifications->other_person_email) {
            $headers['to_email'] = $orderNotifications->other_person_email;
            $headers['to_name'] = '';
            parent::sendEmail($view, $data, $headers);
        }
    }

    protected function sendAdminOrderEmail($view, $data, $headers) {
        $headers['to_email'] = getSettingValue('contact/email');
        $headers['to_name'] = 'Fashion Formula';
        parent::sendEmail($view, $data, $headers);
    }

}
