<?php

namespace App\Services;

use Illuminate\Http\Response;

class PCAPredictService {
    
    const API_URL = 'http://services.postcodeanywhere.co.uk/CapturePlus/Interactive/Find/v2.10/xmla.ws?';

    private $Key,
            $SearchTerm,
            $LastId,
            $SearchFor,
            $Country,
            $LanguagePreference,
            $MaxSuggestions,
            $MaxResults,
            $Data;
    
    public function setConfig(Array $config) {
        foreach ($config as $key => $value) {
            if (isset($this->$key)) {
                $this->$key = $value;
            }
        }
    }

    public function __construct($SearchTerm = null, Array $config = []) {
        $this->Key = env('PCA_KEY', "");
        $this->SearchTerm = $SearchTerm;
        $this->LastId = env('PCA_LAST_ID', "");
        $this->SearchFor = env('PCA_SEARCH_FOR', "");
        $this->Country = env('PCA_COUNTRY', "");
        $this->LanguagePreference = env('PCA_LANGUAGE_PREFERENCE', "");
        $this->MaxSuggestions = env('PCA_MAX_SUGGESTIONS', "");
        $this->MaxResults = env('PCA_MAX_RESULTS', "");
        $this->setConfig($config);
        $this->Data = [];
    }

    public function MakeRequest() {
        $url = env('PCA_API_URL', static::API_URL);
        $url .= "&Key=" . urlencode($this->Key);
        $url .= "&SearchTerm=" . urlencode($this->SearchTerm);
        $url .= "&LastId=" . urlencode($this->LastId);
        $url .= "&SearchFor=" . urlencode($this->SearchFor);
        $url .= "&Country=" . urlencode($this->Country);
        $url .= "&LanguagePreference=" . urlencode($this->LanguagePreference);
        $url .= "&MaxSuggestions=" . urlencode($this->MaxSuggestions);
        $url .= "&MaxResults=" . urlencode($this->MaxResults);
        $file = simplexml_load_file($url);
        if ($file->Columns->Column->attributes()->Name === "Error") {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, "[ID] " . $file->Rows->Row->attributes()->Error . " [DESCRIPTION] " . $file->Rows->Row->attributes()->Description . " [CAUSE] " . $file->Rows->Row->attributes()->Cause . " [RESOLUTION] " . $file->Rows->Row->attributes()->Resolution);
        }
        if (!empty($file->Rows)) {
            $array = json_decode(json_encode($file), true);
            foreach ($array['Rows']['Row'] as $item) {
                $this->Data[] = (object)['id' => $item['@attributes']['Id'], 'label' => $item['@attributes']['Text'], 'value' => $item['@attributes']['Text']];
            }
        }
        return $this->Data;
    }

}
