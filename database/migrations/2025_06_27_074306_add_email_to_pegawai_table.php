<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pegawais', function (Blueprint $table) {
        $table->string('email')->nullable()->after('kontak');
    });
}

public function down()
{
    Schema::table('pegawais', function (Blueprint $table) {
        $table->dropColumn('email');
    });
}

};
