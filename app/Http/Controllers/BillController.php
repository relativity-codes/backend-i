<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillRequest;
use App\Http\Resources\BillResource;
use App\Models\Bill;
use App\Models\Wallet;
use App\Notifications\BillCreatedSmsNotification;
use App\Notifications\BillPaidSmsNotification;
use App\Notifications\FundWalletToPayForBillSmsNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    public function createBill(StoreBillRequest $request): JsonResponse
    {
        $bill = Bill::create([
            'amount' => $request->amount,
            'status' => 'unpaid',
        ]);

        $bill->user->notify(new BillCreatedSmsNotification($bill));

        return response()->json([
            'message' => 'Bill created successfully.',
            'bill' => new BillResource($bill),
        ], 201);
    }

    /**
     * Mark the specified bill as paid.
     */
    public function payBill($validationRef): JsonResponse
    {
        $bill = Bill::where('id', $validationRef)->where('user_id', Auth::id())->first();

        if ($bill->status === 'paid') {
            return response()->json([
                'message' => 'Bill is already paid.',
            ], 400);
        }

        $wallet = Wallet::where('user_id', Auth::id())->first();

        if ($wallet->balance >= $bill->amount) {
            $wallet->update([
                'amount' => $wallet->balance - $bill->amount
            ]);
            $bill->status = 'paid';
            $bill->save();

            $bill->user->notify(new BillPaidSmsNotification($bill));
        } else {
            $bill->user->notify(new FundWalletToPayForBillSmsNotification($bill));
            return response()->json([
                'message' => 'Please fund your wallet.',
                'bill' => new BillResource($bill),
            ], 200);
        }


        return response()->json([
            'message' => 'Bill marked as paid.',
            'bill' => new BillResource($bill),
        ], 200);
    }
}
