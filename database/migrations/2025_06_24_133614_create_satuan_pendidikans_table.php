<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_satuan_pendidikans_table.php
public function up(): void
{
    Schema::create('satuan_pendidikans', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 50); // varchar(25) mungkin kurang
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satuan_pendidikans');
    }
};
