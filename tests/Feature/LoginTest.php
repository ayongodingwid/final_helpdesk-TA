<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase; // Reset database sebelum setiap test

    public function test_user_dapat_login_dengan_credensial_yang_valid()
    {
        // 1. Jalankan Seeder untuk mengisi database
        $this->seed(UserSeeder::class);

        // 2. Ambil user yang sudah dibuat dari seeder
        $user = User::where('userid', '987654321')->first();

        // 3. Simulasi request login
        $response = $this->post('/login', [
            'userid' => '987654321',
            'password' => '223344',
        ]);

        // 4. Pastikan login berhasil dan redirect ke dashboard
        $response->assertRedirect('/dashboard');

        // 5. Pastikan user benar-benar terautentikasi
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_tidak_dapat_login_dengan_credensial_salah()
    {
        // 1. Jalankan seeder agar user tersedia
        $this->seed(UserSeeder::class);

        // 2. Simulasi user memasukkan password yang salah
        $response = $this->post('/login', [
            'userid' => '987654321',
            'password' => '2233445', // Password salah
        ]);

        // 3. Pastikan login gagal dan user tetap di halaman login
        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['userid' => 'Akun tidak ditemukan.']);

        // 4. Pastikan user tetap belum login
        $this->assertGuest();
    }

}
