@extends('layout')

@section('content')
<div class="container p-0">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5">
            <h4 class="fw-bold mb-4">Tulis Artikel Edukasi</h4>
            
            <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Artikel</label>
                    <input type="text" name="title" class="form-control form-control-lg rounded-3" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category" class="form-select rounded-3">
                            <option value="Kehamilan">Kehamilan</option>
                            <option value="Tumbuh Kembang Anak">Tumbuh Kembang Anak</option>
                            <option value="Gizi & Nutrisi">Gizi & Nutrisi</option>
                            <option value="Imunisasi">Imunisasi</option>
                            <option value="Nifas & Menyusui">Nifas & Menyusui</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Gambar Cover</label>
                        <input type="file" name="image" class="form-control rounded-3">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Isi Artikel</label>
                    <textarea name="content" class="form-control rounded-3" rows="10" placeholder="Tulis konten edukasi di sini..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Terbitkan</button>
                <a href="{{ route('artikel.index') }}" class="btn btn-link text-secondary text-decoration-none">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection