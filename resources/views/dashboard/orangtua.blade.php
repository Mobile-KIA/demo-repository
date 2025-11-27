<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Orang Tua</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="card-custom">
            <h3>Dashboard Orang Tua</h3>
            <p>Selamat datang, {{ auth()->user()->name }} (Role: {{ auth()->user()->role }}), Anda hanya dapat melihat data
                namun tidak dapat mengedit.</p>

            <a href="" class="btn btn-success mt-3">Melihat perkembangan kehamilan</a>
        </div>
    @endsection

</body>

</html>
