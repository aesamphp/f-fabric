<?php

namespace App\Http\Controllers\Checkout;

use Validator;

trait ValidatesCheckout {
    
    protected function validateBillingAddress($data) {
        return Validator::make($data, $this->getAddressValidationRules());
    }
    
    protected function validateDeliveryAddress($data) {
        $rules = $this->getAddressValidationRules();
        $rules['weight_branding_id'] = 'required_with:country|integer';
        return Validator::make($data, $rules, ['weight_branding_id.required_with' => 'Please select a delivery option.']);
    }
    
    protected function getAddressValidationRules() {
        return [
            'title' => 'required|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address_line1' => 'required|max:255',
            'address_line2' => 'max:255',
            'city' => 'required|max:255',
            'postcode' => 'required|max:255',
            'state' => 'required_if:country,US|max:255',
            'phone' => 'numeric',
            'country' => 'required|max:255'
        ];
    }
    
    protected function validatePayment($data) {
        return Validator::make($data, [
            'cardType' => 'required|in:VISA,DELTA,MC,MCDEBIT,AMEX,PAYPAL',
            'cardNumber' => 'required_unless:cardType,PAYPAL|numeric|digits_between:13,20',
            'cardHolder' => 'required_unless:cardType,PAYPAL|max:50',
            'month' => 'required_unless:cardType,PAYPAL|numeric',
            'year' => 'required_unless:cardType,PAYPAL|numeric',
            'cv2' => 'required_unless:cardType,PAYPAL|numeric|digits_between:3,4'
        ], ['expiryDate.digits_between' => 'The expiry date must be 4 digits.']);
    }
    
    protected function validateOrderReview($request) {
        return Validator::make($request->all(), [
            'terms' => 'accepted',
            'sales_email' => 'boolean',
            'email_notification' => 'boolean',
            'other_person_email' => 'email'
        ]);
    }

}
