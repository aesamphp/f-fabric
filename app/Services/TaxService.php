<?php

namespace App\Services;

class TaxService {

    private $config = [],
            $status = false,
            $response = null;

    public function setConfig() {
        $this->config = [
            'url' => env('TAX_VIES_URL', 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl')
        ];
    }

    public function __construct() {
        $this->setConfig();
    }

    public function fails() {
        return !$this->status;
    }

    public function getResponse() {
        return $this->response;
    }
    
    public function MakeRequest(Array $params) {
        try {
            $client = new \SoapClient($this->config['url']);
            $this->response = $client->checkVat($params);
            if($this->response->valid) {
                $this->status = true;
            }
        } catch (\Exception $e) {
            $this->response = $e->getMessage();
        }
    }

}
