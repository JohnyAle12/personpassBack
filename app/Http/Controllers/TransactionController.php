<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\TransactionProcessed;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->get();
        return response()->json($transactions);
    }

    public function store(TransactionRequest $request)
    {
        try {
            $transaction = Transaction::create([
                'user_id' => $request->user()->id,
                'account_id' => $request->account_id,
                'state' => 'success',
                'amount' => $request->amount,
                'type' => $request->type,
                'entity' => $request->entity,
                'description' => $request->description
            ]);

            event(new TransactionProcessed(
                $transaction,
                $request->user()
            ));

            return response()->json([
                'message' => 'Transaction was created successfuly',
                'transaction' => $transaction
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
                'trace' => $ex->getTrace()
            ]);
        }   
    }

    public function show(Transaction $transaction)
    {
        return response()->json($transaction);
    }
}
