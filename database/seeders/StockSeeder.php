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

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Stock::create(['product_id' => 1, 'branch_id' => 1, 'quantity' => 50]);
        Stock::create(['product_id' => 2, 'branch_id' => 1, 'quantity' => 30]);
        Stock::create(['product_id' => 3, 'branch_id' => 2, 'quantity' => 20]);
    }
}
