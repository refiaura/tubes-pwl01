<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionController extends Controller
{
    public function index()
    {
        return Transaction::with(['user', 'branch', 'transactionDetails.product'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'date' => 'required|date',
            'total' => 'required|numeric',
            'details' => 'required|array',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|integer',
            'details.*.subtotal' => 'required|numeric',
        ]);

        $transaction = Transaction::create($validated);

        foreach ($validated['details'] as $detail) {
            $detail['transaction_id'] = $transaction->id;
            TransactionDetail::create($detail);
        }

        return $transaction->load(['user', 'branch', 'transactionDetails.product']);
    }

    public function show($id)
    {
        return Transaction::with(['user', 'branch', 'transactionDetails.product'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'branch_id' => 'sometimes|required|exists:branches,id',
            'date' => 'sometimes|required|date',
            'total' => 'sometimes|required|numeric',
        ]);

        $transaction->update($validated);
        return $transaction;
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response(null, 204);
    }
}
