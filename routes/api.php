<?php

use App\Http\Controllers\WalletController;
use App\Http\Controllers\BillController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('wallets/{id}/add-funds', [WalletController::class, 'fundWallet']);
    Route::get('wallet/balance', [WalletController::class, 'checkBalance']);
    Route::get('wallets', [WalletController::class, 'listWallets']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('electricity/verify', [BillController::class, 'createBill']);
    Route::post('Vend/{validationRef}/pay', [BillController::class, 'payBill']);
});
