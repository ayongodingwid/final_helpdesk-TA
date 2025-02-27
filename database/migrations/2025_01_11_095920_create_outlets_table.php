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
        Schema::create('outlets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_unit_id');
            $table->string('name_outlet');
            $table->string('address');
            $table->string('telp_no');
            $table->enum('outlet_status', ['Aktif', 'Tutup', 'Tutup Sementara']);
            $table->boolean('outlet_tipe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlets');
    }
};
