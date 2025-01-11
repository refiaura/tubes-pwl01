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

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Adminnn',
            'email' => 'admin@gmail.com',
            'password' => '12345678', // Plaintext password
            'role' => 'admin',
            'branch_id' => null,
        ]);

        User::create([
            'name' => 'Manager 1',
            'email' => 'manager1@gmail.com',
            'password' => 'password', // Plaintext password
            'role' => 'manager',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Supervisor 1',
            'email' => 'supervisor1@gmail.com',
            'password' => 'password', // Plaintext password
            'role' => 'supervisor',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Cashier 1',
            'email' => 'cashier1@gmail.com',
            'password' => 'password', // Plaintext password
            'role' => 'cashier',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Warehouse Staff 1',
            'email' => 'warehouse1@gmail.com',
            'password' => 'password', // Plaintext password
            'role' => 'warehouse_staff',
            'branch_id' => 1,
        ]);
    }
}
