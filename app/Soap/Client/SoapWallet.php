<?php

namespace App\Soap\Client;

class SoapWallet {

    public function rechargeWallet( $request){

        try {
            $client = new \SoapClient(
                null,
                array(
                    'location' => "http://localhost/api/soap/wallet",
                    'uri' => "http://localhost/api/soap/wallet",
                    'trace' => 1
                )
            );
            
            echo $client->__soapCall("rechargeWallet",
                array($request->document,
                $request->phone,
                $request->amount));

            } catch (\SoapFault $e) {
            echo "Error: " . $e->getMessage();
        }       
    }

    public function checkBalance( $document, $phone ){
        try {
            $client = new \SoapClient(
                null,
                array(
                    'location' => "http://localhost/api/soap/wallet",
                    'uri' => "http://localhost/api/soap/wallet",
                    'trace' => 1
                )
            );
            
            echo $client->__soapCall("checkBalance",
                array($document,
                $phone));

            } catch (\SoapFault $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function pay( $request){

        try {
            $client = new \SoapClient(
                null,
                array(
                    'location' => "http://localhost/api/soap/wallet",
                    'uri' => "http://localhost/api/soap/wallet",
                    'trace' => 1
                )
            );
            
            echo $client->__soapCall("pay",
                array($request->document,
                $request->amount));

            } catch (\SoapFault $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function payConfirm( $request){

        try {
            $client = new \SoapClient(
                null,
                array(
                    'location' => "http://localhost/api/soap/wallet",
                    'uri' => "http://localhost/api/soap/wallet",
                    'trace' => 1
                )
            );
            
            echo $client->__soapCall("payConfirm",
                array($request->sesion,
                $request->token));

            } catch (\SoapFault $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}