<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    // Tambahkan 'user_id' ke fillable/guarded
    protected $guarded = [];

    // protected $fillable = [
    //     'nama',
    //     'nik',
    //     'umur',
    //     'alamat',
    //     'no_telp',
    // ];

    public function kehamilans()
    {
        return $this->hasMany(Pregnancy::class, 'patient_id')
            ->orderBy('created_at', 'desc');
    }

    // Relasi: Pasien (Ibu) memiliki banyak Anak
    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visitSchedules()
    {
        return $this->hasMany(VisitSchedule::class);
    }
}

