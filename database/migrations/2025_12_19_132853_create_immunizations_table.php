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
        Schema::create('immunizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
            $table->date('tanggal_imunisasi');
            $table->string('jenis_vaksin'); // Contoh: BCG, Polio 1, Campak
            $table->string('nomor_batch')->nullable(); // Opsional, penting untuk medis
            $table->text('catatan')->nullable(); // Keluhan pasca imunisasi (KIPI)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('immunizations');
    }
};
