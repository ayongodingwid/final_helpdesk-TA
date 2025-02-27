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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number');
            $table->string('name');
            $table->foreignId('division_id')->nullable();
            $table->string('whatsapp_number');
            $table->foreignId('ticket_subcategory_id');
            $table->enum('status', ['Terkirim', 'Verifikasi', 'Penugasan', 'Pengerjaan', 'Selesai', 'Ditolak'])->default('verifikasi');
            $table->foreignId('approved_by')->nullable();
            $table->foreignId('handle_by')->nullable();
            $table->string('tipe');
            $table->string('alasan_pembatalan')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
