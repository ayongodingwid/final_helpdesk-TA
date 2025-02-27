<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Asset;
use App\Models\BusinessUnit;
use App\Models\AssetCategory;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Crypt;
use Database\Seeders\AsetcategorySeeder;
use Database\Seeders\BusinessunitSeeder;
use Database\Seeders\AsetsubcategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetManagementTest extends TestCase
{
    use RefreshDatabase; // Reset database sebelum setiap test

    public function test_admin_dapat_menambah_aset_baru()
    {
        // 1. Jalankan Seeder
        $this->seed(UserSeeder::class);
        $this->seed(AsetcategorySeeder::class);
        $this->seed(BusinessunitSeeder::class);

        // 2. Ambil user admin dari database
        $admin = User::where('userid', '987654321')->first();
        $this->actingAs($admin);

        // 3. Ambil kategori aset dan business unit
        $assetCategory = AssetCategory::first();
        $businessUnit = BusinessUnit::first();

        // Cek apakah data benar-benar ada
        $this->assertNotNull($assetCategory, "AssetCategory tidak ditemukan!");
        $this->assertNotNull($businessUnit, "BusinessUnit tidak ditemukan!");

        // 4. Kirim data ke endpoint penyimpanan aset
        $response = $this->post(route('asset-store'), [
            'asset_category_id' => $assetCategory->id,
            'asset_name' => 'Laptop Dell',
            'buy_date' => '2024-01-01',
            'buy_price' => 15000000,
            'status' => 'Used',
            'business_unit_id' => $businessUnit->id,
            'user' => 'John Doe',
            'departemen' => 'IT',
            'position_employee' => 'Technician',
            'level_employee' => 'GM',
            'specification' => 'RAM 16GB, SSD 512GB',
            'notes' => 'Diberikan ke karyawan baru',
        ]);

        // 5. Pastikan tidak ada error validasi
        $response->assertSessionHasNoErrors();

        // 6. Pastikan data tersimpan di database
        $this->assertDatabaseHas('assets', [
            'asset_name' => 'Laptop Dell',
            'buy_price' => 15000000,
            'status' => 'Used',
        ]);
    }

    public function test_gagal_menambah_aset_karena_kategori_kosong()
    {
        $this->seed(UserSeeder::class);
        $this->seed(AsetcategorySeeder::class);
        $this->seed(BusinessunitSeeder::class);

        $admin = User::where('userid', '987654321')->first();
        $this->actingAs($admin);

        $businessUnit = BusinessUnit::first();

        $response = $this->post(route('asset-store'), [
            'asset_category_id' => '', // Kosong (tidak valid)
            'asset_name' => 'Laptop Lenovo',
            'buy_date' => '2024-01-01',
            'buy_price' => 14000000,
            'status' => 'New',
            'business_unit_id' => $businessUnit->id,
            'user' => 'John Doe',
            'departemen' => 'IT',
            'position_employee' => 'Technician',
            'level_employee' => 'Manager',
            'specification' => '16GB RAM, 512GB SSD',
            'notes' => 'Untuk karyawan baru',
        ]);

        // Pastikan validasi gagal
        $response->assertSessionHasErrors(['asset_category_id']);

        // Pastikan data tidak tersimpan
        $this->assertDatabaseMissing('assets', [
            'asset_name' => 'Laptop Lenovo',
        ]);
    }

}
