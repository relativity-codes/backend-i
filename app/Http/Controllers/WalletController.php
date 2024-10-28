<?php

namespace App\Http\Controllers;

use App\Http\Requests\FundWalletRequest;
use App\Http\Resources\WalletResource;
use App\Models\Wallet;
use App\Notifications\WalletFundedSmsNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Fund the authenticated user's wallet.
     */
    public function fundWallet(FundWalletRequest $request, $id): JsonResponse
    {
        $wallet = Wallet::where('user_id', $id)->first();
        if (isset($wallet)) {
            $wallet->balance += $request->amount;
            $wallet->save();
            $wallet->user()->notify(new WalletFundedSmsNotification($wallet));
        } else {
            return response()->json(
                [
                    'message' => 'Wallet not found.',
                ],
                404
            );
        }

        return response()->json([
            'message' => 'Wallet funded successfully.',
            'wallet' => new WalletResource($wallet),
        ], 200);
    }

    /**
     * Check the balance of the authenticated user's wallet.
     */
    public function checkBalance(): JsonResponse
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();

        return response()->json([
            'balance' => $wallet->balance,
        ], 200);
    }

    /**
     * List all wallets (admin feature).
     */
    public function listWallets(): JsonResponse
    {
        $wallets = Wallet::all();
        return response()->json(WalletResource::collection($wallets), 200);
    }
}
