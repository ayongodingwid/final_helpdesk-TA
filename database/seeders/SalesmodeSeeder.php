<?php

namespace Database\Seeders;

use App\Models\SalesMode;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SalesmodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SalesMode::create([
            'sales_name' => 'Grab Food'
        ]);
        SalesMode::create([
            'sales_name' => 'Go Food'
        ]);
        SalesMode::create([
            'sales_name' => 'Shopee Food'
        ]);
        SalesMode::create([
            'sales_name' => 'Dine In'
        ]);
        SalesMode::create([
            'sales_name' => 'Take Away'
        ]);
    }
}
