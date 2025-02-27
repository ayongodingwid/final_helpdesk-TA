<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserManagementTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase; // Reset database sebelum setiap test

    public function test_admin_dapat_menambah_akun_baru()
    {
        // 1. Jalankan Seeder untuk mendapatkan Role & User
        $this->seed(UserSeeder::class);

        // 2. Ambil user admin dari database
        $admin = User::where('userid', '987654321')->first();
        $this->actingAs($admin);

        // 3. Ambil role pertama yang tersedia
        $role = Role::first();
        $this->assertNotNull($role, "Role tidak ditemukan!");

        // 4. Kirim data untuk menambah akun
        $response = $this->post(route('la-store'), [
            'userid' => '123456789',
            'password' => 'password123',
            'account_name' => 'User Baru',
            'role_id' => $role->id,
        ]);

        // 5. Pastikan tidak ada error validasi
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('list-akun')); // Pastikan redirect ke daftar akun

        // 6. Pastikan data tersimpan di database
        $this->assertDatabaseHas('users', [
            'userid' => '123456789',
            'account_name' => 'User Baru',
        ]);
    }

    public function test_gagal_menambah_akun_karena_userid_kosong()
    {
        $this->seed(UserSeeder::class); // Seed user roles & permissions

        $admin = User::where('userid', '987654321')->first();
        $this->actingAs($admin);

        $response = $this->post(route('la-store'), [
            'userid' => '', // Kosong (tidak valid)
            'password' => bcrypt('password123'),
            'account_name' => 'User Baru',
            'role_id' => 2,
        ]);

        // Pastikan validasi gagal
        $response->assertSessionHasErrors(['userid']);

        // Pastikan data tidak masuk ke database
        $this->assertDatabaseMissing('users', [
            'account_name' => 'User Baru',
        ]);
    }

}
