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

    public function edit($id)
    {
        // Ambil transaksi beserta detailnya
        $transaction = Transaction::with('details')->findOrFail($id);

        // Data lain yang mungkin dibutuhkan untuk form
        $branches = Branches::all();
        $users = User::all();
        $products = Product::all();

        return view('transactions.edit', compact('transaction', 'branches', 'users', 'products'));
    }

    /**
     * Memperbarui transaksi beserta detailnya.
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'date' => 'required|date',
            'total' => 'required|numeric',
            'details' => 'required|array',
            'details.*.id' => 'nullable|exists:transaction_details,id',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.subtotal' => 'required|numeric|min:0',
        ]);

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Update transaksi utama
            $transaction->update([
                'user_id' => $validated['user_id'],
                'branch_id' => $validated['branch_id'],
                'date' => $validated['date'],
                'total' => $validated['total'],
            ]);

            // Ambil ID detail transaksi yang sudah ada
            $existingDetailIds = collect($validated['details'])->pluck('id')->filter();

            // Hapus detail transaksi yang tidak ada di input
            TransactionDetail::where('transaction_id', $transaction->id)
                ->whereNotIn('id', $existingDetailIds)
                ->delete();

            // Perbarui atau tambahkan detail transaksi
            foreach ($validated['details'] as $detail) {
                if (!empty($detail['id'])) {
                    // Perbarui detail transaksi yang ada
                    $transactionDetail = TransactionDetail::find($detail['id']);
                    $transactionDetail->update([
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity'],
                        'subtotal' => $detail['subtotal'],
                    ]);
                } else {
                    // Tambahkan detail transaksi baru
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity'],
                        'subtotal' => $detail['subtotal'],
                    ]);
                }
            }

            // Commit transaksi database
            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaction updated successfully.');
        } catch (\Exception $e) {
            // Rollback jika terjadi kesalahan
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update transaction. Please try again.']);
        }
    }

    /**
     * Menghapus transaksi beserta semua detailnya.
     */
    public function destroy($id)
    {
        try {
            // Begin transaction
            DB::beginTransaction();

            // Hapus detail transaksi terlebih dahulu
            TransactionDetail::where('transaction_id', $id)->delete();

            // Hapus transaksi utama
            Transaction::findOrFail($id)->delete();

            // Commit transaction
            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaction deleted successfully.');
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete transaction. Please try again.']);
        }
    }
}
