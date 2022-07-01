<?php

namespace App\Http\Controllers\Checkout;

use Illuminate\Http\Request;
use App\Services\SagepayService;
use App\Services\XmlFileGenerator;

trait HandleSagePayTransaction {
    
    use HandleDesign,
        HandleOrder;
    
    public function processPayment(Request $request) {
        $validator = $this->validateOrderReview($request);
        if ($validator->fails()) {
            return redirect()->route('view.checkout.order.review')
                    ->withErrors($validator)
                    ->withInput();
        }
        session()->put('orderNotifications', (object)$request->only(['sales_email', 'email_notification', 'other_person_email']));
        $sagepayService = new SagepayService;
        $api = $sagepayService->buildAPI((array)session()->get('checkoutPayment'));
        if (getBasketGrandTotal() == 0 && isDiscountApplied()) {
            return $this->successPayment(\SagepayCommon::encryptedOrder($api));
        }
        $response = $api->createRequest();
        $data = $api->getData();
        $data += $response;
        return $this->handlePaymentResponse($response, $data);
    }
    
    public function showPaypal(Request $request) {
        $paypalData = session()->get('PAYPAL');
        if ($paypalData === null) {
            return redirect()->route('view.checkout.order.review')
                    ->with('error', SagepayService::ERROR_PAYPAL);
        }
        session()->forget('PAYPAL');
        return view('checkout.paypal', ['paypalData' => $paypalData]);
    }
    
    public function showPaypalResult(Request $request) {
        $data = session()->get('sagepayApiData');
        $sagepayConfig = \SagepaySettings::getInstance(config('sagepay'));
        $paypalData = $this->getPaypalResultArray($sagepayConfig, $request, $data);
        $result = \SagepayCommon::requestPost($sagepayConfig->getPurchaseUrl('paypal'), $paypalData);
        if (($result['Status'] == SAGEPAY_REMOTE_STATUS_OK) || ($result['Status'] == SAGEPAY_REMOTE_STATUS_REGISTERED)) {
            foreach ($data as $key => $value) {
                if (!isset($result[$key])) {
                    $result[$key] = $value;
                }
            }
            session()->forget('sagepayApiData');
            return $this->successPayment($result);
        }
        return redirect()->route('view.checkout.order.review')
                ->with('error', (isset($result['StatusDetail'])) ? $result['StatusDetail'] : SagepayService::ERROR_PAYPAL);
    }
    
    public function showSecure3D(Request $request) {
        $threeDSecure = session()->get('3DAUTH');
        if ($threeDSecure === null) {
            return redirect()->route('view.checkout.order.review')
                    ->with('error', SagepayService::ERROR_3DAUTH);
        }
        $purchaseURL = $threeDSecure->ACSURL;
        unset($threeDSecure->ACSURL);
        session()->forget('3DAUTH');
        return view('checkout.secure3d', ['purchaseURL' => $purchaseURL, 'threeDSecure' => $threeDSecure]);
    }
    
    public function showSecure3DResult(Request $request) {
        $data = session()->get('sagepayApiData');
        $result = \SagepayCommon::requestPost(\SagepaySettings::getInstance(config('sagepay'))->getPurchaseUrl('direct3d'), $request->all());
        if (in_array($result['Status'], array(SAGEPAY_REMOTE_STATUS_AUTHENTICATED, SAGEPAY_REMOTE_STATUS_REGISTERED, SAGEPAY_REMOTE_STATUS_OK))) {
            foreach ($data as $key => $value) {
                if (!isset($result[$key])) {
                    $result[$key] = $value;
                }
            }
            session()->forget('sagepayApiData');
            return $this->successPayment($result);
        }
        return redirect()->route('view.checkout.order.review')
                ->with('error', (isset($result['StatusDetail'])) ? $result['StatusDetail'] : SagepayService::ERROR_3DAUTH);
    }
    
    protected function handlePaymentResponse($response, $data) {
        if ($response['Status'] === SAGEPAY_REMOTE_STATUS_PAYPAL_REDIRECT) {
            $paypalData = ['PayPalRedirectURL' => $response['PayPalRedirectURL']];
            session()->put('sagepayApiData', $data);
            session()->put('PAYPAL', (object)$paypalData);
            return redirect()->route('view.checkout.paypal');
        } else if ($response['Status'] === "3DAUTH") {
            $threeDSecure = [
                'MD' => $response['MD'],
                'ACSURL' => $response['ACSURL'],
                'PaReq' => $response['PAReq'],
                'TermUrl' => route('view.checkout.secure3d.result') . '?' . \SagepayUtil::arrayToQueryString(['vtx' => $data['VendorTxCode']])
            ];
            session()->put('sagepayApiData', $data);
            session()->put('3DAUTH', (object)$threeDSecure);
            return redirect()->route('view.checkout.secure3d');
        } else if (in_array($response['Status'], array(SAGEPAY_REMOTE_STATUS_OK, SAGEPAY_REMOTE_STATUS_REGISTERED))) {
            return $this->successPayment($data);
        }
        return redirect()->route('view.checkout.order.review')
                ->with('error', (isset($response['StatusDetail'])) ? $response['StatusDetail'] : SagepayService::ERROR);
    }
    
    protected function successPayment($data) {
        $orderNotifications = session()->get('orderNotifications');
        $this->createDesign();
        $order = $this->createOrder($data);
        if (!isset($order->id)) {
            return $order;
        }
        getAuthenticatedUser()->update(['sales_email' => $orderNotifications->sales_email]);
        $xmlFile = new XmlFileGenerator($order->getXMLFilePath(), $order->buildXMLElementsArray());
        $xmlFile->generate();
        $this->sendOrderEmail($order, $orderNotifications);
        $this->forgetSessions();
        session()->put('orderID', $order->id);
        return redirect()->route('view.checkout.confirmation');
    }
    
    protected function getPaypalResultArray($sagepayConfig, $request, $data) {
        return [
            'VPSProtocol' => $sagepayConfig->getProtocolVersion(),
            'TxType' => SAGEPAY_TXN_COMPLETE,
            'VPSTxId' => $request->input('VPSTxId'),
            'Amount' => number_format($data['Amount'], 2),
            'Accept' => ($request->input('Status') == SAGEPAY_REMOTE_STATUS_PAYPAL_OK) ? 'YES' : 'NO'
        ];
    }
    
    protected function forgetSessions() {
        session()->forget('destinationPath');
        session()->forget('designImages');
        session()->forget('basket');
        session()->forget('checkoutBillingAddress');
        session()->forget('checkoutDeliveryAddress');
        session()->forget('discountCodeId');
        session()->forget('orderNotifications');
    }

}
