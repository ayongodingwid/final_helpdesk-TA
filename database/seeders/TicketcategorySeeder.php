<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TicketcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketCategory::create([
            'name' => 'Penanganan Masalah',
            'code' => 'PM'
        ]);
        TicketCategory::create([
            'name' => 'Permintaan Aset',
            'code' => 'PA'
        ]);
        TicketCategory::create([
            'name' => 'Menu & BOM',
            'code' => 'MB'
        ]);
        TicketCategory::create([
            'name' => 'Program Promo',
            'code' => 'PP'
        ]);
        TicketCategory::create([
            'name' => 'Discount',
            'code' => 'DC'
        ]);
        TicketCategory::create([
            'name' => 'Selisih Harga',
            'code' => 'SH'
        ]);
        TicketCategory::create([
            'name' => 'Void',
            'code' => 'VD'
        ]);
        TicketCategory::create([
            'name' => 'COA ',
            'code' => 'CA'
        ]);
        TicketCategory::create([
            'name' => 'Product ',
            'code' => 'PR'
        ]);
        TicketCategory::create([
            'name' => 'Supplier ',
            'code' => 'SR'
        ]);
    }
}
