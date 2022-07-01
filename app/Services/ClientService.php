<?php

namespace App\Services;

use WhichBrowser\Parser;
use Illuminate\Http\Request;

class ClientService {
    
    public static function getDetails() {
        $request = Request::capture();
        $client = new Parser($request->header('User-Agent'));
        return (object)[
            'browser' => (isset($client->browser->name)) ? $client->browser->name : null,
            'version' => (isset($client->browser->version->value)) ? $client->browser->version->value : 0,
            'os' => (isset($client->os->name)) ? $client->os->name : null
        ];
    }
    
}