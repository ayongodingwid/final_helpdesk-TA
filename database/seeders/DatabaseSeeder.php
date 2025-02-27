<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\BackofficeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TicketcategorySeeder::class,
            TicketsubcategorySeeder::class,
            SalesmodeSeeder::class,
            DivisionSeeder::class,
            BusinessunitSeeder::class,
            BackofficeSeeder::class,
            AsetcategorySeeder::class,
            AsetsubcategorySeeder::class
        ]);
    }
}
