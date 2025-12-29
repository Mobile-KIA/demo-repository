<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    // Kolom yang boleh diisi
    protected $fillable = ['patient_id', 'title', 'date', 'time'];

    // Relasi balik ke Pasien
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
