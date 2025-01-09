<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;

class TransactionDetailController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi beserta relasi user, branch, dan transactionDetails.product
        $transactions = TransactionDetail::with(['user', 'branch', 'transactionDetails.product'])->get();

        // Kirim data ke view transactions.index
        return view('transactions.index', compact('transactions'));
    }
}
