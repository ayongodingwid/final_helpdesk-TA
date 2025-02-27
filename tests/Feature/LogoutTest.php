<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\UserSeeder;

class LogoutTest extends TestCase
{
    use RefreshDatabase; // Reset database sebelum setiap test

    public function test_user_dapat_logout_dengan_benar()
    {
        // 1. Jalankan Seeder untuk mengisi database dengan user
        $this->seed(UserSeeder::class);

        // 2. Ambil user dari database
        $user = User::where('userid', '987654321')->first();

        // 3. Login sebagai user
        $this->actingAs($user);

        // 4. Lakukan request logout
        $response = $this->post('/logout');

        // 5. Pastikan user diarahkan ke halaman login setelah logout
        $response->assertRedirect('/');

        // 6. Pastikan user tidak lagi terautentikasi
        $this->assertGuest();
    }
}
