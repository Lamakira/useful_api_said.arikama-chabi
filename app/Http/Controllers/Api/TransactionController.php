<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all(['id', 'sender_id', 'receiver_id', 'amount', 'status', 'created_at']);
        return response()->json($transactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function transfer(TransactionRequest $request) {
        $validatedData = $request->validated();

        $sender_id = $request->user()->id;
        $receiver_id = $validatedData["receiver_id"];
        $sender_wallet = Wallet::where('user_id', $sender_id)->first();
        $receiver_wallet = Wallet::where('user_id', $receiver_id)->first();
        $sender_wallet_id = $sender_wallet['id'];
        $receiver_wallet_id = $receiver_wallet['id'];
        $currentBalance = $sender_wallet['balance'];
        $amount = $validatedData['amount'];

        if($sender_id === $receiver_id) {
            return response()->json([
                "error" => "You can't send money to yourself"
            ], 403);
        }

        if($currentBalance - $amount < 0) {
            return response()->json([], 400);
        }

        try {
            DB::transaction(function () use ($sender_wallet_id, $receiver_wallet_id, $amount) {
                DB::table('wallets')->where('user_id', $sender_wallet_id)->decrement('balance', $amount);

                DB::table('wallets')->where('user_id', $receiver_wallet_id)->increment('balance', $amount);

               $transaction = DB::table('transactions')->insert([
                    'sender_id' => $sender_wallet_id,
                    'receiver_id' => $receiver_wallet_id,
                    'amount' => $amount,
                    'status' => 'success',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json($transaction, 201);
            });
        } catch (e) {
            return response()->json([
                "message" => "Something went wrong"
            ], 500);
        }

        return response()->json([
            "message" => "Something went wrong"
        ], 500);
    }
}
