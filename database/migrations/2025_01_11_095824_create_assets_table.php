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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('no_idasset');
            $table->foreignId('asset_category_id');
            $table->string('asset_name');
            $table->timestamp('buy_date');
            $table->integer('buy_price');
            $table->enum('status', ['used', 'vacant', 'lost of stolen', 'out of repair']);
            $table->foreignId('business_unit_id');
            $table->string('user');
            $table->string('departemen');
            $table->string('position_employee');
            $table->enum('level_employee', ['GM','Manager', 'SPV', 'Staff']);
            $table->text('specification');
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};

