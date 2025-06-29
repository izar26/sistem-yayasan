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
        $table->unsignedBigInteger('id_satuan_pendidikan')->after('id')->nullable();

        // foreign key constraint
        $table->foreign('id_satuan_pendidikan')->references('id')->on('satuan_pendidikans')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('pegawais', function (Blueprint $table) {
        $table->dropForeign(['id_satuan_pendidikan']);
        $table->dropColumn('id_satuan_pendidikan');
    });
}

};
