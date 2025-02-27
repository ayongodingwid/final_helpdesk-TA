<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('daftar_tiket')->default(false);
            $table->string('daftar_tiket_option')->nullable()->default('[]');
            $table->string('penanganan_masalah')->default(false);
            $table->string('penanganan_masalah_option')->nullable()->default('[]');
            $table->string('pengajuan_aset')->default(false);
            $table->string('pengajuan_aset_option')->nullable()->default('[]');
            $table->string('menu_bom')->default(false);
            $table->string('menu_bom_option')->nullable()->default('[]');
            $table->string('program_promo')->default(false);
            $table->string('program_promo_option')->nullable()->default('[]');
            $table->string('diskon')->default(false);
            $table->string('diskon_option')->nullable()->default('[]');
            $table->string('selisih_harga')->default(false);
            $table->string('selisih_harga_option')->nullable()->default('[]');
            $table->string('void')->default(false);
            $table->string('void_option')->nullable()->default('[]');
            $table->string('list_outlet')->default(false);
            $table->string('list_outlet_option')->nullable()->default('[]');
            $table->string('coa')->default(false);
            $table->string('coa_option')->nullable()->default('[]');
            $table->string('product')->default(false);
            $table->string('product_option')->nullable()->default('[]');
            $table->string('supplier')->default(false);
            $table->string('supplier_option')->nullable()->default('[]');
            $table->string('bisnis_unit')->default(false);
            $table->string('bisnis_unit_option')->nullable()->default('[]');
            $table->string('divisi')->default(false);
            $table->string('divisi_option')->nullable()->default('[]');
            $table->string('karyawan')->default(false);
            $table->string('karyawan_option')->nullable()->default('[]');
            $table->string('mode_penjualan')->default(false);
            $table->string('mode_penjualan_option')->nullable()->default('[]');
            $table->string('backoffice')->default(false);
            $table->string('backoffice_option')->nullable()->default('[]');
            $table->string('aset')->default(false);
            $table->string('aset_option')->nullable()->default('[]');
            $table->string('ticket_kategori')->default(false);
            $table->string('ticket_kategori_option')->nullable()->default('[]');
            $table->string('aset_kategori')->default(false);
            $table->string('aset_kategori_option')->nullable()->default('[]');
            $table->string('akun_role')->default(false);
            $table->string('akun_role_option')->nullable()->default('[]');
            $table->string('list_akun')->default(false);
            $table->string('list_akun_option')->nullable()->default('[]');
            $table->string('faq')->default(false);
            $table->string('faq_option')->nullable()->default('[]');
            $table->string('articles')->default(false);
            $table->string('articles_option')->nullable()->default('[]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
