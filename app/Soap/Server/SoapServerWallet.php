<?
namespace App\Soap\server;

use App\Http\Controllers\Controller;
use App\Services\WalletService;

class SoapServerWallet extends Controller{

    public function init(){
        
        try {
            $server = new \SoapServer(
            NULL,
            array(
                'uri' => 'http://localhost/api/soap/wallet'
                )
            );
            
            $walletService = app(WalletService::class);
            $server->setObject($walletService);
            $server->handle();
            
        } catch (\Exception $th) {
            $errorXml = sprintf(
                '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><SOAP-ENV:Body><SOAP-ENV:Fault><faultcode>SOAP-ENV:Client</faultcode><faultstring>%s</faultstring></SOAP-ENV:Fault></SOAP-ENV:Body></SOAP-ENV:Envelope>',
                $th->getMessage()
            );

            // Envía el mensaje de error en formato XML
            header('Content-Type: text/xml; charset=utf-8');
            echo $errorXml;
            exit;
        }
    }
}