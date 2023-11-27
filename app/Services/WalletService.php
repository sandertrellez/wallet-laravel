<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Mail\tokenMail;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Wallet;
use Illuminate\Support\Facades\Mail;

class WalletService extends Controller{
    //Recarga de saldo
    public function rechargeWallet($document, $phone, $amount) {

        $client = Client::where('document', $document)
            ->where('phone', $phone)
            ->first();

        if (!$client) {
            return json_encode(['status' => 'Error','message' => 'Cliente no encontrado']);
        }

        // Recupera la billetera del cliente
        $wallet = $client->wallet;

        // Realiza la recarga de la billetera
        $wallet->balance += $amount;
        $wallet->save();

        return json_encode(['status' => 'Exito','message' => 'Recarga exitosa','client' => $client->names, 'nuevo_saldo' => $wallet->balance]);
    }

    //Consulta de saldo
    public function checkBalance($document, $phone) {

        $client = Client::where('document', $document)
            ->where('phone', $phone)
            ->first();

        if (!$client) {
            return json_encode(['status'=>'Error',
            'message' => "Cliente no encontrado, verifique el documento y celular"]);
        }

        // Recupera la billetera del cliente
        $wallet = $client->wallet;

        return json_encode(['status' =>'Exito', 'Cliente' => $client->names, 'saldo' => $wallet->balance]);
    }

    //Solcitud de pago
    public function pay($document, $amount) {

        $client = Client::where('document', $document)
            ->first();

        if (!$client) {
            return json_encode(['status' => 'Error','message' => 'Cliente no encontrado']);
        }

        $token = random_int(100000, 999999);

        //Se registra la solicitud de pago
        $payment = new Payment();
        $payment->client =  $client->id;
        $payment->amount = $amount;
        $payment->status =  'GENERATED';
        $payment->token =  $token;
        $payment->save();

        Mail::to($client->email)->send(new tokenMail($payment->id, $token));

        return json_encode(['status' => 'Exito', 'message' => 'Pago generado, debe confirmar con token',
        'sesion' => $payment->id]);
    }

    //Confirmación de pago
    public function payConfirm($sesion, $token) {

        $payment = Payment::where('id', $sesion)
        ->where('token', $token)
        ->where('status', 'GENERATED')
        ->orderBy('created_at', 'desc')
        ->first();

        if (!$payment) {
            return json_encode(['status' => 'Error','message' => 'Sesión o token incorrecto']);
        }

        //Se obtiene la wallet para descontar el valor pagado
        $wallet = Wallet::where('client', $payment->client)
        ->first();

        $wallet->balance -= $payment->amount;
        $wallet->save();

        if(!$wallet){
            return json_encode(['status' => 'Error','message' => 'Billetera no encontrada']);
        }

        //se actualiza el estado del pago, para evitar doble confirmación
        $payment->status = 'FINISHED';
        $payment->save();

        return json_encode(['status' => 'Exito', 'message' => 'Pago confirmado correctamente', "saldo"=>$wallet->balance]);
    }
}