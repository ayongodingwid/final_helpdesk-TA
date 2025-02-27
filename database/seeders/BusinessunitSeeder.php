<?php

namespace Database\Seeders;

use App\Models\BusinessUnit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusinessunitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusinessUnit::create([
            'name_bu' => "Payakumbuah",
            'code' => 'PYK'
        ]);
        BusinessUnit::create([
            'name_bu' => "Baso Aci Akang",
            'code' => 'BAA'
        ]);
        BusinessUnit::create([
            'name_bu' => "Acihuy",
            'code' => 'ACY'
        ]);
        BusinessUnit::create([
            'name_bu' => "Kopi Sejahtera",
            'code' => 'KPS'
        ]);
        BusinessUnit::create([
            'name_bu' => "Sunatku",
            'code' => 'SNK'
        ]);
    }
}
