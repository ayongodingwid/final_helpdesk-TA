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
        Schema::create('asset_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id');
            $table->string('asset_name');
            $table->text('quantity');
            $table->string('asset_receiver');
            $table->string('asset_receiver_position');
            $table->string('position');
            $table->foreignId('business_unit_id');
            $table->text('description');
            $table->string('note');
            $table->string('expectation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_requests');
    }
};
