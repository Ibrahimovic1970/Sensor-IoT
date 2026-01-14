<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sensors', function (Blueprint $table) {
            $table->string('lokasi')->nullable()->after('nama_sensor');
        });
    }

    public function down()
    {
        Schema::table('sensors', function (Blueprint $table) {
            $table->dropColumn('lokasi'); // hapus kolom saat rollback
        });
    }
};