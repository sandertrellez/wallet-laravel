<?php

namespace App\Http\Controllers;

use App\Soap\Client\SoapClient;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function registerClient(Request $request){

        $client = new SoapClient();
        return $client->registerClient($request);
        
    }
}
