<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name_role' => "Administrator",
            'permission_id' => 1
        ]);
        
        User::create([
            'userid' => '987654321',
            'password' => bcrypt('223344'),
            'account_name' => 'Admin',
            'role_id' => 1
        ]);

        Permission::create([
            'daftar_tiket' => 1,
            'daftar_tiket_option' => json_encode(['read']),
            'penanganan_masalah' => 1,
            'penanganan_masalah_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'penanganan_masalah' => 1,
            'penanganan_masalah_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'pengajuan_aset' => 1,
            'pengajuan_aset_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'menu_bom' => 1,
            'menu_bom_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'program_promo' => 1,
            'program_promo_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'diskon' => 1,
            'diskon_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'selisih_harga' => 1,
            'selisih_harga_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'void' => 1,
            'void_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'list_outlet' => 1,
            'list_outlet_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'coa' => 1,
            'coa_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'product' => 1,
            'product_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'supplier' => 1,
            'supplier_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'bisnis_unit' => 1,
            'bisnis_unit_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'divisi' => 1,
            'divisi_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'karyawan' => 1,
            'karyawan_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'mode_penjualan' => 1,
            'mode_penjualan_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'backoffice' => 1,
            'backoffice_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'aset' => 1,
            'aset_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'ticket_kategori' => 1,
            'ticket_kategori_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'aset_kategori' => 1,
            'aset_kategori_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'akun_role' => 1,
            'akun_role_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'list_akun' => 1,
            'list_akun_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'faq' => 1,
            'faq_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
            'articles' => 1,
            'articles_option' => json_encode(['create', 'read', 'update', 'delete', 'approve']),
        ]);
    }
}
