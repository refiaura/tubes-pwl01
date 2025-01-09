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

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Product::create(['name' => 'Product A', 'description' => 'Description A', 'price' => 10000, 'category' => 'Category 1']);
        Product::create(['name' => 'Product B', 'description' => 'Description B', 'price' => 20000, 'category' => 'Category 2']);
        Product::create(['name' => 'Product C', 'description' => 'Description C', 'price' => 30000, 'category' => 'Category 3']);
    }
}
