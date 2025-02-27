<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketSubcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TicketsubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketSubcategory::create([
            'name' => 'Komputer & Laptop Error',
            'code' => 'PCE',
            'approval_status' => false,
            'ticket_category_id' => 1
        ]);
        TicketSubcategory::create([
            'name' => 'Internet & Wifi Error',
            'code' => 'IWE',
            'approval_status' => false,
            'ticket_category_id' => 1
        ]);
        TicketSubcategory::create([
            'name' => 'Printer Error',
            'code' => 'PRE',
            'approval_status' => false,
            'ticket_category_id' => 1
        ]);
        TicketSubcategory::create([
            'name' => 'Permintaan Aset',
            'code' => 'PAS',
            'approval_status' => false,
            'ticket_category_id' => 2
        ]);
        TicketSubcategory::create([
            'name' => 'Penambahan Menu & Bom',
            'code' => 'AMB',
            'approval_status' => false,
            'ticket_category_id' => 3
        ]);
        TicketSubcategory::create([
            'name' => 'Penghapusan Menu & Bom',
            'code' => 'HMB',
            'approval_status' => false,
            'ticket_category_id' => 3
        ]);
        TicketSubcategory::create([
            'name' => 'Perubahan Menu & Bom',
            'code' => 'UMB',
            'approval_status' => false,
            'ticket_category_id' => 3
        ]);
        TicketSubcategory::create([
            'name' => 'Penambahan Promo',
            'code' => 'PPR',
            'approval_status' => false,
            'ticket_category_id' => 4
        ]);
        TicketSubcategory::create([
            'name' => 'Penambahan Diskon',
            'code' => 'PDC',
            'approval_status' => false,
            'ticket_category_id' => 5
        ]);
        TicketSubcategory::create([
            'name' => 'Selisih Harga',
            'code' => 'SLH',
            'approval_status' => false,
            'ticket_category_id' => 6
        ]);
        TicketSubcategory::create([
            'name' => 'Void',
            'code' => 'VOD',
            'approval_status' => false,
            'ticket_category_id' => 7
        ]);
        TicketSubcategory::create([
            'name' => 'COA',
            'code' => 'COA',
            'approval_status' => false,
            'ticket_category_id' => 8
        ]);
        TicketSubcategory::create([
            'name' => 'Penambahan Product',
            'code' => 'APL',
            'approval_status' => false,
            'ticket_category_id' => 9
        ]);
        TicketSubcategory::create([
            'name' => 'Penghapusan Product',
            'code' => 'DPL',
            'approval_status' => false,
            'ticket_category_id' => 9
        ]);
        TicketSubcategory::create([
            'name' => 'Perubahan Product',
            'code' => 'EPL',
            'approval_status' => false,
            'ticket_category_id' => 9
        ]);
        TicketSubcategory::create([
            'name' => 'Penambahan SUpplier',
            'code' => 'ASL',
            'approval_status' => false,
            'ticket_category_id' => 10
        ]);
        TicketSubcategory::create([
            'name' => 'Penghapusan SUpplier',
            'code' => 'Dsl',
            'approval_status' => false,
            'ticket_category_id' => 10
        ]);
        TicketSubcategory::create([
            'name' => 'Perubahan SUpplier',
            'code' => 'ESL',
            'approval_status' => false,
            'ticket_category_id' => 10
        ]);
    }
}
