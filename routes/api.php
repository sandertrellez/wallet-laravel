<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\WalletController;
use App\Soap\server\SoapServerClient;
use App\Soap\server\SoapServerWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Rutas Soap
Route::any('/soap/client',[SoapServerClient::class, 'init']);
Route::any('/soap/wallet',[SoapServerWallet::class, 'init']);
Route::any('/soap/pay',[SoapServerWallet::class, 'init']);


//Rutas Rest
Route::post('/client',[ClientController::class, 'registerClient']);
Route::post('/wallet',[WalletController::class, 'rechargeWallet']);
Route::get('/wallet/{document}/{phone}',[WalletController::class, 'checkBalance']);
Route::post('/pay',[WalletController::class, 'pay']);
Route::post('/confirm',[WalletController::class, 'payConfirm']);
