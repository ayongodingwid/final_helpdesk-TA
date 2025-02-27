<?php

namespace Database\Seeders;

use App\Models\AssetSubcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsetsubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssetSubcategory::create([
            'asset_category_id'=>'1',
            'name'=>'Komputer',
            'code'=>'PC'
        ]);

        AssetSubcategory::create([
            'asset_category_id'=>'1',
            'name'=>'Lapotop',
            'code'=>'LP'
        ]);
        
        AssetSubcategory::create([
            'asset_category_id'=>'1',
            'name'=>'Router',
            'code'=>'RR'
        ]);
    }
}
