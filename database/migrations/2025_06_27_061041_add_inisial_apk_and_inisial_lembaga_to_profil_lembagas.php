<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('profil_lembagas', function (Blueprint $table) {
            $table->string('inisial_apk', 255);
            $table->string('inisial_lembaga', 255);
        });
    }

    public function down(): void
    {
        Schema::table('profil_lembagas', function (Blueprint $table) {
            $table->dropColumn(['inisial_apk', 'inisial_lembaga']);
        });
    }
};
