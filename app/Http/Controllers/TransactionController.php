<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Branches;
use App\Models\User;
use App\Models\Product;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi beserta relasi user, branch, dan transactionDetails.product
        $transactions = Transaction::with(['user', 'branch', 'transactionDetails.product'])->get();

        // Kirim data ke view transactions.index
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $transactions = Transaction::all();
        $branches = Branches::all();
        $users = User::all();
        $products = Product::all();

        // Kirim data ke view
        return view('transactions.create', compact('transactions', 'branches', 'users', 'products'));
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

        try {
            // Begin transaction
            DB::beginTransaction();

            // Create the transaction
            $transaction = Transaction::create([
                'user_id' => $validated['user_id'],
                'branch_id' => $validated['branch_id'],
                'date' => $validated['date'],
                'total' => $validated['total'],
            ]);

            // Create transaction details
            foreach ($validated['details'] as $detail) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'subtotal' => $detail['subtotal'],
                ]);
            }

            // Commit transaction
            DB::commit();

            // Redirect to index with success message
            return redirect()->route('transactions.index')
                ->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            // Redirect back with input and error message
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create transaction. Please try again.']);
        }
    }


    public function show($id)
    {
        // Fetch the transaction with its related details, user, branch, and products
        $transaction = Transaction::with(['user', 'branch', 'details.product'])
            ->findOrFail($id);

        // Return the view with transaction data
        return view('transactions.show', compact('transaction'));
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
