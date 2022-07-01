<?php

namespace App\Services;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payout;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\PayoutItem;
use PayPal\Api\Currency;

class PaypalService {
    
    private $apiContext,
            $status = false,
            $response = null;
    
    public function setApiContext() {
        $this->apiContext = new ApiContext(new OAuthTokenCredential(env('PAYPAL_CLIENT_ID', ''), env('PAYPAL_CLIENT_SECRET', '')));
        $this->apiContext->setConfig([
            'mode' => env('PAYPAL_MODE', 'live')
        ]);
    }
    
    public function fails() {
        return !$this->status;
    }
    
    public function getResponse() {
        return $this->response;
    }
    
    public function __construct() {
        $this->setApiContext();
    }
    
    public function makePayoutRequest() {
        $payouts = new Payout;
        $senderBatchHeader = new PayoutSenderBatchHeader;
        $senderBatchHeader->setSenderBatchId(uniqid())
                ->setEmailSubject("You have a Payout!");
        $payouts->setSenderBatchHeader($senderBatchHeader)
                ->addItem($this->getPayoutSenderItem());
        try {
            $this->response = $payouts->createSynchronous($this->apiContext);
            $this->status = true;
        } catch (\Exception $e) {
            $this->response = $e->getMessage();
        }
    }
    
    private function getPayoutSenderItem() {
        $senderItem = new PayoutItem;
        return $senderItem->setRecipientType('Email')
                ->setNote('Thank you for your business!')
                ->setReceiver('ammaarlatif_14@hotmail.co.uk')
                ->setSenderItemId("143")
                ->setAmount(new Currency('{
                        "value":"2.0",
                        "currency":"GBP"
                    }'));
    }
    
}
