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
        Schema::create('children', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel patients (Ibunya siapa?)
            // onDelete('cascade') artinya jika data Ibu dihapus, data anak ikut terhapus
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');

            $table->string('nama');
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);

            // Data saat lahir (Opsional, boleh kosong)
            $table->float('berat_lahir')->nullable(); // kg
            $table->float('tinggi_lahir')->nullable(); // cm

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('children');
    }
};
