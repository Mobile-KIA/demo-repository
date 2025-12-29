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
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tabel patients (pastikan nama tabel pasien kamu adalah 'patients')
        $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
        $table->string('title'); // Contoh: Imunisasi, Cek Kandungan
        $table->date('date');
        $table->time('time');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
