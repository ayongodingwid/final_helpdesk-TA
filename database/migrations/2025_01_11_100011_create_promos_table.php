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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id');
            $table->foreignId('business_unit_id');
            $table->foreignId('sales_mode_id');
            $table->string('name');
            $table->timestamp('date_start');
            $table->timestamp('date_end');
            $table->enum('promo_status', ['Aktif', 'Nonaktif']);
            $table->string('attachment_path');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
