<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::create([
            'division_name' => 'HRGA'
        ]);
        Division::create([
            'division_name' => 'LEGAL'
        ]);
        Division::create([
            'division_name' => 'OPS PAYAKUMBUAH'
        ]);
        Division::create([
            'division_name' => 'OPS BASO ACI AKANG'
        ]);
        Division::create([
            'division_name' => 'OPS ACIHUY'
        ]);
        Division::create([
            'division_name' => 'ICT'
        ]);
        Division::create([
            'division_name' => 'COST CONTROL'
        ]);
        Division::create([
            'division_name' => 'FINANCE'
        ]);
        Division::create([
            'division_name' => 'ACCOUNTING'
        ]);
        Division::create([
            'division_name' => 'TAX'
        ]);
        Division::create([
            'division_name' => 'PURCHASING'
        ]);
    }
}
