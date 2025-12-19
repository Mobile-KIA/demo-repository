<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChildGrowth extends Model
{
    protected $guarded = [];
    protected $casts = [
        'tanggal' => 'date',
    ];

    public function up()
{
    Schema::create('child_growths', function (Blueprint $table) {
        $table->id();
        $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
        $table->date('tanggal');
        $table->float('berat_badan'); // kg
        $table->float('tinggi_badan'); // cm
        $table->float('lingkar_kepala')->nullable(); // cm (opsional)
        $table->text('catatan')->nullable();
        $table->timestamps();
    });
}
}
