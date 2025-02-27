<?php

namespace Database\Seeders;

use App\Models\Backoffice;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BackofficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Backoffice::create([
            'backoffice_name' => 'ESB BASO ACI AKANG'
        ]);
        Backoffice::create([
            'backoffice_name' => 'ESB PAYAKUMBUAH'
        ]);
        Backoffice::create([
            'backoffice_name' => 'POST ACIHUY'
        ]);
        Backoffice::create([
            'backoffice_name' => 'JURNAL ID AKASA'
        ]);
        Backoffice::create([
            'backoffice_name' => 'ESB AKASA'
        ]);
        Backoffice::create([
            'backoffice_name' => 'ACCURATE BASO ACI AKANG'
        ]);
    }
}
