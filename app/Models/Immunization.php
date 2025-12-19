<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Immunization extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'tanggal_imunisasi' => 'date',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}