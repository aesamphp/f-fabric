<?php

namespace App\Models;

use Milon\Barcode\Facades\DNS1DFacade as DNS1D;

class Order extends AppModel
{

    const XML_DESTINATION_PATH = 'downloads/xml/orders';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['vendorTxCode', 'txType', 'actual_amount', 'amount', 'currency', 'applyAVSCV2', 'apply3DSecure', 'allowGiftAid', 'basketXML', 'surchargeXML', 'cardType', 'accountType', 'status', 'statusDetail', 'vPSTxId', 'securityKey', 'txAuthNo', 'aVSCV2', 'addressResult', 'postCodeResult', 'cV2Result', '3DSecureStatus', 'declineCode', 'bankAuthCode', 'vat', 'surcharge', 'dispatched', 'tracking_number'];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['aVSCV2', 'addressResult', 'postCodeResult', 'cV2Result', '3DSecureStatus', 'declineCode', 'bankAuthCode', 'tracking_number'];

    /**
     * The lazy eager loading attributes of the model.
     *
     * @var array
     */
    protected $load = ['user', 'orderItems.design.type', 'orderItems.design.images', 'orderItems.product.category', 'orderItems.material', 'billingAddress', 'shippingAddress', 'discountCodeUsed'];

    /**
     * Returns the xml elements array.
     *
     * @return array
     */
    public function buildXMLElementsArray()
    {
        $array = [
            'order' => [
                'id' => $this->friendly_id,
                'date' => formatDate($this->created_at),
                'numberOfItems' => $this->orderItems()->count(),
                'weight' => $this->getWeight(),
                'customer' => $this->user->buildOrderCustomerXMLElementsArray(),
                'shippingDetails' => $this->shippingAddress->buildOrderShippingAddressXMLElementsArray(),
            ],
        ];
        foreach ($this->orderItems as $key => $orderItem) {
            $array['order']['products'][] = array_merge(['itemNumber' => $key + 1], $orderItem->buildOrderItemXMLElementsArray());
        }

        return $array;
    }

    /**
     * Get the user that belongs to order.
     *
     * @return array
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the order items that belongs to order.
     *
     * @return array
     */
    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    /**
     * Get the billing address that belongs to order.
     *
     * @return array
     */
    public function billingAddress()
    {
        return $this->hasOne('App\Models\OrderBillingAddress');
    }

    /**
     * Get the shipping address that belongs to order.
     *
     * @return array
     */
    public function shippingAddress()
    {
        return $this->hasOne('App\Models\OrderShippingAddress');
    }

    /**
     * Get the feedback that belongs to order.
     *
     * @return array
     */
    public function orderfeedback()
    {
        return $this->hasMany('App\Models\OrderFeedback');
    }

    /**
     * Get the discount code used that belongs to order.
     *
     * @return array
     */
    public function discountCodeUsed()
    {
        return $this->hasOne('App\Models\DiscountCodeUsed');
    }

    /**
     * Returns the order subtotal amount.
     *
     * @return float
     */
    public function getSubtotalAmount()
    {
        return ($this->amount + $this->getDiscountAmount()) - ($this->getShippingAmount() + $this->vat);
    }

    /**
     * Returns the order shipping amount.
     *
     * @return float
     */
    public function getShippingAmount()
    {
        return $this->shippingAddress->price;
    }

    /**
     * Returns the order discount amount.
     *
     * @return float
     */
    public function getDiscountAmount()
    {
        return ($this->hasDiscount()) ? $this->discountCodeUsed->amount : 0;
    }

    /**
     * Returns the order discount code.
     *
     * @return string
     */
    public function getDiscountCode()
    {
        return ($this->hasDiscount()) ? $this->discountCodeUsed->getDiscountCode() : null;
    }

    /**
     * Returns the order total amount.
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->amount + $this->surcharge;
    }

    /**
     * Returns the order vat.
     *
     * @return float
     */
    public function calculateVAT()
    {
        return calculateVAT($this->amount);
    }

    /**
     * Returns if the order is dispatched or not.
     *
     * @return boolean
     */
    public function isDispatched()
    {
        return $this->dispatched === 1;
    }

    /**
     *
     * @return array
     */
    public function getCurrency()
    {
        return Currency::where('code', $this->currency)
            ->first();
    }

    /**
     * Returns the order status.
     *
     * @return string
     */
    public function getStatus()
    {
        return ($this->isDispatched()) ? 'Dispatched' : 'In Progress';
    }

    /**
     * Returns the order status class.
     *
     * @return string
     */
    public function getStatusClass()
    {
        return str_slug($this->getStatus());
    }

    /**
     * Returns if the order is trackable or not.
     *
     * @return boolean
     */
    public function isTrackable()
    {
        return $this->isDispatched() && $this->tracking_number && $this->getTrackingLink();
    }

    /**
     * Returns the order tracking link.
     *
     * @return string
     */
    public function getTrackingLink()
    {
        return $this->shippingAddress->branding->tracking_link;
    }

    /**
     * Returns if the order has discount or not.
     *
     * @return boolean
     */
    public function hasDiscount()
    {
        return ($this->discountCodeUsed) ? true : false;
    }

    /**
     * Check's if order has vat applied or not.
     *
     * @return boolean
     */
    public function hasVAT()
    {
        return $this->vat > 0;
    }

    /**
     * Return's the order weight.
     *
     * @return int
     */
    public function getWeight()
    {
        $weight = 0;
        foreach ($this->orderItems as $orderItem) {
            $weight = $weight + $orderItem->getWeight();
        }

        return $weight;
    }

    /**
     * Returns the xml file destination path.
     *
     * @return string
     */
    public function getXMLFilePath()
    {
        return static::XML_DESTINATION_PATH . '/order_' . $this->friendly_id . '.xml';
    }

    /**
     * Function to perform default actions on events.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = getAuthenticatedUser()->id;
        });
        static::created(function ($model) {
            $setting = Setting::where('path', 'general/order_id_prefix')->first();
            $prefix = ($setting) ? $setting->value : 'ON';
            $model->friendly_id = $prefix . $model->id;
            $model->update();
        });
    }

    public function getBarcode()
    {
        return DNS1D::getBarcodeSVG((string)$this->id, "C128", 4, 50);
    }

}
