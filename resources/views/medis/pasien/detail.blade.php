@extends('layout')

@section('content')
    <div class="card-custom">
        <h4>Detail Pasien: {{ $patient->nama }}</h4>

        <p><b>NIK:</b> {{ $patient->nik }}</p>
        <p><b>Umur:</b> {{ $patient->umur }}</p>
        <p><b>Alamat:</b> {{ $patient->alamat }}</p>
        <p><b>No Telp:</b> {{ $patient->no_telp }}</p>

        <hr>

        <h5>Riwayat Kehamilan:</h5>

        @foreach ($patient->pregnancies as $p)
            <div class="border p-2 mb-2">
                <b>Usia Kehamilan:</b> {{ $p->usia_kehamilan }} minggu<br>
                <b>Berat:</b> {{ $p->berat_badan }} kg<br>
                <b>Tinggi:</b> {{ $p->tinggi_badan }} cm<br>
                <b>Tekanan Darah:</b> {{ $p->tekanan_darah }}<br>
                <b>Keluhan:</b> {{ $p->keluhan ?? '-' }}<br>
            </div>
        @endforeach
    </div>
@endsection
