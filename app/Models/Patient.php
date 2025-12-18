<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'nama',
        'nik',
        'umur',
        'alamat',
        'no_telp'
    ];

    public function kehamilans()
    {
        return $this->hasMany(Pregnancy::class, 'patient_id')
                    ->orderBy('created_at', 'desc');
    }
}
