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
        Schema::create('child_growths', function (Blueprint $table) {
            $table->id();
            // Kolom ini yang hilang dan menyebabkan error:
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade');

            $table->date('tanggal');
            $table->float('berat_badan');
            $table->float('tinggi_badan');
            $table->float('lingkar_kepala')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_growths');
    }
};
