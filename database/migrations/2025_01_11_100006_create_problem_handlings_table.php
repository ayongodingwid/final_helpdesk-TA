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
        Schema::create('problem_handlings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id');
            $table->string('location');
            $table->text('description');
            $table->text('laporan_perbaikan')->nullable();
            // $table->string('attachment_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problem_handlings');
    }
};
