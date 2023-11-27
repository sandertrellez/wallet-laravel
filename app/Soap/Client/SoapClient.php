<?php

namespace App\Soap\Client;

class SoapClient {

    public function registerClient( $request){

        try {
            $client = new \SoapClient(
                null,
                array(
                    'location' => "http://localhost/api/soap/client",
                    'uri' => "http://localhost/api/soap/client",
                    'trace' => 1
                )
            );
            
            echo $client->__soapCall("registerClient",
                array($request->document,
                $request->names,
                $request->email,
                $request->phone));

            } catch (\SoapFault $e) {
            echo "Error: " . $e->getMessage();
        }
        
       
    }
}