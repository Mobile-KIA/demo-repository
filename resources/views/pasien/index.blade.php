@extends('layout')

@section('content')
<h3>Data Pasien</h3>

<a href="{{ route('pasien.create') }}" class="btn btn-primary mb-3">
    Tambah Pasien
</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Nama</th>
        <th>NIK</th>
        <th>Aksi</th>
    </tr>

    @foreach($patients as $patient)
    <tr>
        <td>{{ $patient->nama }}</td>
        <td>{{ $patient->nik }}</td>
        <td>
            <a href="{{ route('pasien.show', $patient->id) }}">Detail</a> |
            <a href="{{ route('pasien.edit', $patient->id) }}">Edit</a>
        </td>
    </tr>
    @endforeach
</table>
@endsection
