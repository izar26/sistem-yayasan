<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_admins_table.php
public function up(): void
{
    Schema::create('admins', function (Blueprint $table) {
        $table->id(); // Menggantikan int(11) NOT NULL AUTO_INCREMENT
        $table->string('username', 25)->unique(); // Sebaiknya username unik
        $table->string('email', 50)->nullable()->unique(); // Sebaiknya email juga unik
        $table->string('password'); // Panjang default 255 sudah cukup
        $table->string('photo', 100)->nullable();
        $table->timestamps(); // Menambahkan created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
