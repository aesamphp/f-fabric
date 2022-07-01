<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use App\Services\BucksNetService;
use Validator;

trait UserPaymentTrait {

    public function storePayment(Request $request) {
        $this->setModel(new PaymentDetail);
        $redirect = redirect()->route('view.user.account.tab', ['tab' => 'payment']);
        $validator = Validator::make($request->all(), $this->getModel()->rules(), $this->getModel()->messages());
        if ($validator->fails()) {
            return $redirect->withErrors($validator)->withInput();
        }
        if ($request->input('country') === "GB") {
            $validator = Validator::make($request->all(), $this->getModel()->bucksnetRules(), $this->getModel()->messages());
            if ($validator->fails()) {
                return $redirect->withErrors($validator)->withInput();
            }
            $bucksnet = $this->handleBucksnetAccountSetup($request);
            if ($bucksnet->fails()) {
                return $redirect->with('error', $bucksnet->getResponse())->withInput();
            }
            $request->merge(['bucksnet_id' => $bucksnet->getResponse()->AccountSetupResult]);
        }
        parent::storeEntity($request->all(), $redirect);
        return $redirect->with('status', 'Payment details saved successfully!');
    }

    public function updatePayment(Request $request) {
        $this->setModel(new PaymentDetail);
        $user = getAuthenticatedUser();
        $redirect = redirect()->route('view.user.account.tab', ['tab' => 'payment']);
        $validator = Validator::make($request->all(), $this->getModel()->rules(), $this->getModel()->messages());
        if ($validator->fails()) {
            return $redirect->withErrors($validator)->withInput();
        }
        if ($request->input('country') === "GB") {
            $validator = Validator::make($request->all(), $this->getModel()->bucksnetRules(), $this->getModel()->messages());
            if ($validator->fails()) {
                return $redirect->withErrors($validator)->withInput();
            }
            if ($user->hasBucksnetPaymentDetails()) {
                $bucksnet = $this->handleBucksnetAccountUpdate($request, $user->paymentDetail);
            } else {
                $bucksnet = $this->handleBucksnetAccountSetup($request);
            }
            if ($bucksnet->fails()) {
                return $redirect->with('error', $bucksnet->getResponse())->withInput();
            }
            if (!$user->hasBucksnetPaymentDetails()) {
                $request->merge(['bucksnet_id' => $bucksnet->getResponse()->AccountSetupResult]);
            }
        }
        parent::updateEntity($request->all(), $user->paymentDetail->id, $redirect);
        return $redirect->with('status', 'Payment details saved successfully!');
    }

    public function showBucksnetPayment(Request $request) {
        return view('user.account.bucksnet-form-fields', ['bucksnet' => getAuthenticatedUser()->getBucksnetDetails()]);
    }

    protected function handleBucksnetAccountSetup($request) {
        $bucksnet = new BucksNetService;
        $bucksnet->MakeRequest(BucksNetService::ACTION_ACCOUNT_SETUP, [
            'AccountName' => $request->input('account_holder_name'),
            'AccountNo' => $request->input('account_number'),
            'SortCode' => $request->input('sort_code'),
            'Reference' => getAuthenticatedUser()->friendly_id
        ]);
        return $bucksnet;
    }

    protected function handleBucksnetAccountUpdate($request, $paymentDetail) {
        $bucksnet = new BucksNetService;
        $bucksnet->MakeRequest(BucksNetService::ACTION_ACCOUNT_CHANGE_DETAILS, [
            'AccountReference' => $paymentDetail->bucksnet_id,
            'AccountName' => $request->input('account_holder_name'),
            'AccountNo' => $request->input('account_number'),
            'SortCode' => $request->input('sort_code'),
            'Reference' => getAuthenticatedUser()->friendly_id
        ]);
        return $bucksnet;
    }

}
