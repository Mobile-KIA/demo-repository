<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregnancy extends Model
{
    protected $fillable = [
        'patient_id',
        'usia_kehamilan',
        'berat_badan',
        'tinggi_badan',
        'tekanan_darah',
        'keluhan'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
