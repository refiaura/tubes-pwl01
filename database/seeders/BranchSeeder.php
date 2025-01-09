<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branches;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Branches::create(['name' => 'Branch 1', 'location' => 'City A']);
        Branches::create(['name' => 'Branch 2', 'location' => 'City B']);
        Branches::create(['name' => 'Branch 3', 'location' => 'City C']);
    }
}
