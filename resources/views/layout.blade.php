<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Aplikasi Kehamilan' }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fa;
        }
        .card-custom {
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            background: white;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-primary px-4">
        <a class="navbar-brand" href="#">Kesehatan Ibu dan Anak</a>

        @auth
            <a href="/logout" class="btn btn-light btn-sm">Logout</a>
        @endauth
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

</body>
</html>
