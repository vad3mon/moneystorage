<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionCollection;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function getTransactions(Request $request, $id)
    {
        $transactions = Transaction::get()->where('user_id', $id);

        $days = $transactions->groupBy('date');

        $sums = $days->sum('sum');

        return response()->json([
            new TransactionCollection($transactions)
        ],200);
    }

    public function getTransaction(Request $request, $id)
    {
        $transaction = Transaction::query()->find($id);
        if (!$transaction)
        {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        return response()->json([
            $transaction
        ],200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "account_id" => "required",
            "date" => "required|date",
            "category" => "string",
            "description" => "string",
            "sum" => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $transaction = new Transaction();
        $transaction->user_id = $request['user_id'];
        $transaction->account_id = $request['account_id'];
        $transaction->date = $request['date'];
        $transaction->category = $request['category'];
        $transaction->description = $request['description'];
        $transaction->sum = $request['sum'];
        $transaction->save();

        return response()->json([
            'status' => true,
            'transaction' => $transaction
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "account_id" => "required",
            "date" => "required|date",
            "category" => "string",
            "description" => "string",
            "sum" => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $transaction = Transaction::query()->find($id);
        if (!$transaction)
        {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        $transaction->user_id = $request['user_id'];
        $transaction->account_id = $request['account_id'];
        $transaction->date = $request['date'];
        $transaction->category = $request['category'];
        $transaction->description = $request['description'];
        $transaction->sum = $request['sum'];
        $transaction->save();

        return response()->json([
            'status' => true,
            'transaction' => $transaction
        ], 200);

    }

    public function delete($id)
    {
        $transaction = Transaction::query()->find($id);

        if (!$transaction)
        {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sucessful'
        ], 201);
    }
}
