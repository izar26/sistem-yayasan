<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_tapels_table.php
public function up(): void
{
    Schema::create('tapels', function (Blueprint $table) {
        $table->id();
        $table->string('tapel', 25);
        $table->text('ket')->nullable();
        $table->boolean('status')->default(false); // Menggunakan boolean untuk status aktif/tidak
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tapels');
    }
};
