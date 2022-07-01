<?php

namespace App\Services;

class BucksNetService {
    
    const ACTION_ACCOUNT_SETUP = 'AccountSetup';
    const ACTION_ACCOUNT_RETRIEVE_DETAILS = 'AccountRetrieveDetails';
    const ACTION_ACCOUNT_CHANGE_DETAILS = 'AccountChangeDetails';
    const ACTION_ACCOUNT_ADD_INSTRUCTION = 'AccountAddInstruction';
    const ACTION_VALIDATE_ACCOUNT = 'ValidateAccount';

    private $config = [],
            $status = false,
            $response = null,
            $actionsWithServiceUserNumber = [];

    public function setConfig() {
        $this->config = [
            'headerbody' => [
                'Username' => env('BUCKS_NET_USERNAME', 'fashionformula-web'),
                'Password' => env('BUCKS_NET_PASSWORD', 'o?:EI|6r')
            ],
            'ServiceUserNumber' => env('BUCKS_NET_SERVICE_USER_NUMBER', '445555'),
            'URL' => env('BUCKS_NET_URL', 'https://bacs.bucks.net/Service.asmx')
        ];
    }
    
    public function setActionsWithServiceUserNumber() {
        $this->actionsWithServiceUserNumber = [
            static::ACTION_ACCOUNT_SETUP,
            static::ACTION_ACCOUNT_RETRIEVE_DETAILS,
            static::ACTION_ACCOUNT_CHANGE_DETAILS,
            static::ACTION_ACCOUNT_ADD_INSTRUCTION
        ];
    }

    public function __construct() {
        $this->setConfig();
        $this->setActionsWithServiceUserNumber();
    }
    
    public function fails() {
        return !$this->status;
    }
    
    public function getResponse() {
        return $this->response;
    }
    
    public function MakeRequest($action, Array $params) {
        if (in_array($action, $this->actionsWithServiceUserNumber)) {
            $params = array_add($params, 'ServiceUserNumber', $this->config['ServiceUserNumber']);
        }
        try {
            $client = new \SoapClient($this->config['URL'] . '?wsdl');
            $header = new \SOAPHeader($this->config['URL'], 'AuthenticationHeader', $this->config['headerbody']);
            $client->__setSoapHeaders($header);
            $this->response = $client->__soapCall($action, [$action => $params]);
            $this->setStatus();
        } catch (\Exception $e) {
            $this->response = $e->getMessage();
        }
    }
    
    private function setStatus() {
        $this->status = true;
        if (isset($this->response->ValidateAccountResult)) {
            $errors = ['INVALID_ACCOUNTNO', 'INVALID_SORTCODE'];
            if (in_array($this->response->ValidateAccountResult, $errors)) {
                $this->status = false;
            }
        }
    }

}
