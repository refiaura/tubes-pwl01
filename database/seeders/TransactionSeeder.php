<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Hash;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $transaction = Transaction::create([
            'user_id' => 4, // Cashier 1
            'branch_id' => 1,
            'date' => now(),
            'total' => 50000,
        ]);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => 1,
            'quantity' => 2,
            'subtotal' => 20000,
        ]);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => 2,
            'quantity' => 1,
            'subtotal' => 30000,
        ]);
    }
}
