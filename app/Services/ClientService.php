<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Wallet;

class ClientService extends Controller
{

    public function registerClient($document, $names, $email, $phone)
    {
        //Se verifiva si el cliente ya está registrado
        $existingClient = Client::where('document',$document) -> first();

        if ($existingClient) {
            return json_encode(['status'=>'Error','message' => "El cliente ya está registrado"]);
            
        }

        // Crear un nuevo cliente
        $client = new Client();
        $client->document = $document;
        $client->names = $names;
        $client->email = $email;
        $client->phone = $phone;

        $client->save();

        //Una vez registrado el clinete se le crea la billetera con saldo 0
        $wallet = new Wallet();
        $wallet->client = $client->id;
        $wallet->balance = 0;
        $wallet->save();
        return json_encode(['status'=>'Exito','message' => "Cliente registrado correctamente"]);
    }

}
