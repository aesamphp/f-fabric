<?php

namespace App\Services;

use Illuminate\Http\Response;
use App\Models\Basket;

class SagepayService {
    
    const ERROR = 'Error processing your payment. Please try again!';
    const ERROR_3DAUTH = '3DAUTH error. Please try again!';
    const ERROR_PAYPAL = 'PAYPAL error. Please try again!';
    
    private $cardTypes = [
        ['id' => 'VISA', 'title' => 'VISA Credit', 'icon' => 'images/card-visa.png'],
        ['id' => 'DELTA', 'title' => 'VISA Debit', 'icon' => 'images/card-visa-debit.png'],
        ['id' => 'MC', 'title' => 'MasterCard', 'icon' => 'images/card-master-card.png'],
        ['id' => 'MCDEBIT', 'title' => 'Debit MasterCard', 'icon' => 'images/card-master-card-debit.png'],
        ['id' => 'AMEX', 'title' => 'American Express', 'icon' => 'images/card-american-express.png'],
        ['id' => 'PAYPAL', 'title' => 'Paypal', 'icon' => 'images/paypal.png']
    ];
    
    private $defaultCustomerKeys = [
        'first_name' => 'firstname',
        'last_name' => 'lastname',
        'address_line1' => 'address1',
        'address_line2' => 'address2',
        'city' => 'city',
        'postcode' => 'postcode',
        'country' => 'country',
        'state' => 'state',
        'phone' => 'phone'
    ];
    
    /**
     * Define SagepaySettings
     *
     * @var SagepaySettings
     */
    private $sagepayConfig;
    
    /**
     * Set SagepaySettings for controller
     *
     * @param SagepaySettings $sagepayConfig
     */
    public function setSagepayConfig(\SagepaySettings $sagepayConfig) {
        $this->sagepayConfig = $sagepayConfig;
    }
    
    public function getsetSagepayConfig() {
        return $this->sagepayConfig;
    }
    
    public function __construct() {
        $settings = \SagepaySettings::getInstance(config('sagepay'));
        $this->setSagepayConfig($settings);
    }
    
    public function buildAPI(Array $card = []) {
        $api = \SagepayApiFactory::create(SAGEPAY_DIRECT, $this->sagepayConfig);
        if (is_null($api)) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, static::ERROR);
        }
        $api->setBasket($this->buildBasket());
        $api->addAddress($this->createCustomerDetails('billing'));
        $api->addAddress($this->createCustomerDetails('delivery'));
        if ($card['cardType'] === 'PAYPAL') {
            $api->setIntegrationMethod(SAGEPAY_PAYPAL);
            $this->sagepayConfig->setPaypalCallbackUrl(route('view.checkout.paypal.result'));
        }
        $api->setPaneValues($card);
        $api->setVpsDirectUrl($this->sagepayConfig->getPurchaseUrl(SAGEPAY_DIRECT));
        return $api;
    }
    
    private function buildBasket() {
        $basket = $this->getBasketFromProducts();
        $basket->setDeliveryNetAmount(getShippingActualPrice(true));
        $basket->setDeliveryTaxAmount((shouldPayVAT()) ? getShippingActualVAT() : 0);
        $basket->setDescription('Fashion Formula Shopping Basket.');
        if (isDiscountApplied()) {
            $basket->setDiscounts($this->getBasketDiscounts());
        }
        return $basket;
    }
    
    private function createCustomerDetails($type) {
        $customerdetails = new \SagepayCustomerDetails();
        $data = ($type === 'billing') ? session()->get('checkoutBillingAddress') : session()->get('checkoutDeliveryAddress');
        foreach ($this->defaultCustomerKeys as $key => $value) {
            if (isset($data->$key)) {
                $customerdetails->$value = $data->$key;
            }
        }
        if ($type === 'billing') {
            $customerdetails->email = getAuthenticatedUser()->email;
        }
        return $customerdetails;
    }
    
    private function getBasketFromProducts() {
        $basket = false;
        foreach (Basket::getBasketItems() as $basketItem) {
            if ($basket === false) {
                $basket = new \SagepayBasket();
            }
            $basket->addItem($this->getBasketItem($basketItem));
        }
        return $basket;
    }
    
    private function getBasketItem($basketItem) {
        if (Basket::isDesign($basketItem)) {
            $description = (Basket::isSavedDesign($basketItem)) ? $basketItem->design->friendly_id : $basketItem->design_images->fileOriginalName;
        } else {
            $description = $basketItem->product->title;
        }
        $item = new \SagepayItem();
        $item->setDescription($description);
        $item->setUnitTaxAmount((shouldPayVAT()) ? $basketItem->actual_vat : 0);
        $item->setQuantity($basketItem->quantity);
        $item->setUnitNetAmount($basketItem->actual_net_price);
        return $item;
    }
    
    private function getBasketDiscounts() {
        return [
            'discount' => ['fixed' => getDiscountAmount(true), 'description' => 'Promo Code']
        ];
    }
    
    public static function getCardTypes() {
        $cardTypes = [];
        foreach ((new SagepayService)->cardTypes as $card) {
            $cardTypes[] = (object)$card;
        }
        return (object)$cardTypes;
    }
    
    public static function getCardType($id) {
        $cardType = null;
        foreach (static::getCardTypes() as $card) {
            if ($id === $card->id) {
                $cardType = $card->title;
            }
        }
        return $cardType;
    }

}
