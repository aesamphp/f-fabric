<?php

namespace App;

use Validator;
use App\Models\PaymentDetail;
use App\Services\BucksNetService;
use App\Services\TaxService;
use App\Models\WeeklyContest;
use App\Models\User;
use App\Models\Order;
use App\Models\Design;

class ValidatorExtend {

    /**
     * Registers your custom validation methods.
     */
    public function register() {
        $validatorExtendObject = $this;
        $methods = (new \ReflectionClass($validatorExtendObject))->getMethods(\ReflectionMethod::IS_PROTECTED);
        foreach ($methods as $method) {
            $methodName = $method->name;
            Validator::extend($methodName, function ($attribute, $value, $parameters, $validator) use ($validatorExtendObject, $methodName) {
                return $validatorExtendObject->$methodName($attribute, $value, $parameters, $validator);
            });
        }
    }
    
    /**
     * Validates an image.
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param \Validator $validator
     * 
     * @return boolean
     */
    protected function validateImage($attribute, $value, $parameters, $validator) {
        $mimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/tiff'];
        return in_array($value->getMimeType(), $mimeTypes);
    }
    
    /**
     * Validates vat number.
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param \Validator $validator
     * 
     * @return boolean
     */
    protected function validateVatNumber($attribute, $value, $parameters, $validator) {
        $data = $validator->getData();
        if ($value && PaymentDetail::isEUCountry($data['country'])) {
            $taxService = new TaxService;
            $taxService->MakeRequest(['countryCode' => PaymentDetail::getEUVIESCountryCode($data['country']), 'vatNumber' => $value]);
            return ($taxService->fails()) ? false : true;
        }
        return true;
    }
    
    /**
     * Validates bank details.
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param \Validator $validator
     * 
     * @return boolean
     */
    protected function validateBankDetails($attribute, $value, $parameters, $validator) {
        $data = $validator->getData();
        $bucksnet = new BucksNetService;
        $bucksnet->MakeRequest(BucksNetService::ACTION_VALIDATE_ACCOUNT, [
            'AccountNo' => $data['account_number'],
            'SortCode' => $value
        ]);
        return !$bucksnet->fails();
    }
    
    /**
     * Validates blocked terms.
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param \Validator $validator
     * 
     * @return boolean
     */
    protected function validateBlockedTerms($attribute, $value, $parameters, $validator) {
        foreach (termsToBlock() as $term) {
            if (str_contains($value, $term)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Validates weekly contest dates.
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param \Validator $validator
     * 
     * @return boolean
     */
    protected function validateContestDates($attribute, $value, $parameters, $validator) {
        $data = $validator->getData();
        return WeeklyContest::validateDates($value, $data['to_date']);
    }
    
    /**
     * Validates commission user.
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param \Validator $validator
     * 
     * @return boolean
     */
    protected function validateSaleUser($attribute, $value, $parameters, $validator) {
        $user = User::where(function ($query) use ($value) {
                    $query->where('friendly_id', $value)
                            ->orWhere('username', $value)
                            ->orWhere('email', $value);
                })
                ->where('disabled', 0)
                ->first();
        return !is_null($user);
    }
    
    /**
     * Validates commission order.
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param \Validator $validator
     * 
     * @return boolean
     */
    protected function validateSaleOrder($attribute, $value, $parameters, $validator) {
        $order = Order::where('friendly_id', $value)->where('disabled', 0)->first();
        return !is_null($order);
    }
    
    /**
     * Validates commission design.
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param \Validator $validator
     * 
     * @return boolean
     */
    protected function validateSaleDesign($attribute, $value, $parameters, $validator) {
        $design = Design::where('friendly_id', $value)->where('disabled', 0)->first();
        return !is_null($design);
    }
    
    /**
     * Validates commission designer.
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param \Validator $validator
     * 
     * @return boolean
     */
    protected function validateSaleDesigner($attribute, $value, $parameters, $validator) {
        $data = $validator->getData();
        $user = User::where(function ($query) use ($data) {
                    $query->where('friendly_id', $data['user_friendly_id'])
                            ->orWhere('username', $data['user_friendly_id'])
                            ->orWhere('email', $data['user_friendly_id']);
                })
                ->where('disabled', 0)
                ->first();
        if ($user) {
            $design = Design::where('friendly_id', $value)->where('user_id', $user->id)->where('disabled', 0)->first();
            return !is_null($design);
        }
        return false;
    }

}
