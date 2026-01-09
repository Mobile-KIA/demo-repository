<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VisitSchedule extends Model
{
    protected $guarded = [];
    protected $casts = ['tanggal_kunjungan' => 'date'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}