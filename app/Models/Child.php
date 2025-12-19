<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $guarded = [];

    // Agar tanggal otomatis dibaca sebagai objek Date oleh Laravel
    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    // Relasi: Anak milik satu Pasien (Ibu)
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function growths()
    {
        // Kita urutkan dari yang terbaru (agar data terakhir muncul paling atas)
        return $this->hasMany(ChildGrowth::class)->latest('tanggal');
    }

    // Fitur Tambahan: Menghitung Usia Otomatis
    // Cara panggil di view: $child->usia
    public function getUsiaAttribute()
    {
        // Hasil contoh: "2 tahun 3 bulan" (format tergantung setting locale Carbon)
        return Carbon::parse($this->tgl_lahir)->diffForHumans(null, true);
    }
}
