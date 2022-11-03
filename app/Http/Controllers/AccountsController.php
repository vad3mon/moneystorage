<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{
    public function getAll(Request $request)
    {
        return response()->json([
            Account::get()->all()
        ], 200);
    }

    public function getAccount(Request $request, $id)
    {
        $account = Account::query()->find($id);

        if (!$account) {
            return response()->json([
                'message' => 'Account not found'
            ], 404);
        }

        return response()->json([
            $account
        ],200);
    }

    public function getAccounts(Request $request, $id)
    {
        $accounts = Account::query()->where('user_id', $id)->get();

        if (!$accounts) {
            return response()->json([
                'message' => 'Account not found'
            ], 404);
        }

        return response()->json([
            $accounts
        ],200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "balance" => "required|numeric",
            "user_id" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $account = new Account();
        $account->name = $request['name'];
        $account->user_id = $request['user_id'];
        $account->balance = $request['balance'];
        $account->save();

        return response()->json([
            'status' => true,
            'account' => $account
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "balance" => "required|numeric",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $account = Account::query()->find($id);
        if (!$account)
        {
            return response()->json([
               'message' => 'Account not found'
            ], 404);
        }

        $account->name = $request['name'];
        $account->balance = $request['balance'];
        $account->save();

        return response()->json([
            'status' => true,
            'account' => $account
        ], 200);

    }

    public function delete($id)
    {
        $account = Account::query()->find($id);

        if (!$account)
        {
            return response()->json([
                'message' => 'Account not found'
            ], 404);
        }

        $account->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sucessful'
        ], 201);
    }
}
