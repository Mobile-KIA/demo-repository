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
    Schema::table('patients', function (Blueprint $table) {
        // Kita buat nullable dulu biar data lama ga error
        $table->date('tgl_lahir')->nullable()->after('nik');
    });
}

public function down()
{
    Schema::table('patients', function (Blueprint $table) {
        $table->dropColumn('tgl_lahir');
    });
}
};
