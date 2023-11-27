<?php

namespace App\Http\Controllers;

use App\Soap\Client\SoapWallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function rechargeWallet(Request $request){

        $client = new SoapWallet();
        return $client->rechargeWallet($request);
        
    }
    public function checkBalance($document, $phone){

        $client = new SoapWallet();
        return $client->checkBalance($document, $phone);
        
    }

    public function pay(Request $request){

        $client = new SoapWallet();
        return $client->pay($request);
        
    }

    public function payConfirm(Request $request){

        $client = new SoapWallet();
        return $client->payConfirm($request);
        
    }
}
