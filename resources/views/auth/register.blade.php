@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card-custom mt-4 p-4">
                <h3 class="text-center mb-3">Register</h3>

                <form method="POST" action="/register" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required autocomplete="new-password">
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="Orang Tua">Orang Tua</option>
                            <option value="Tenaga Medis">Tenaga Medis</option>
                        </select>
                    </div>

                    <button class="btn btn-primary w-100">Register</button>
                </form>

                <p class="text-center mt-3">
                    Sudah punya akun? <a href="/login">Login</a>
                </p>
            </div>

        </div>
    </div>
@endsection
