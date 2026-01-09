@extends('layout')

@section('content')
<div class="container p-0">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5">
            <h4 class="fw-bold mb-4">Edit Artikel</h4>
            
            <form action="{{ route('artikel.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- PENTING UNTUK UPDATE --}}

                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Artikel</label>
                    <input type="text" name="title" class="form-control form-control-lg rounded-3" value="{{ $article->title }}" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category" class="form-select rounded-3">
                            <option value="Kehamilan" {{ $article->category == 'Kehamilan' ? 'selected' : '' }}>Kehamilan</option>
                            <option value="Tumbuh Kembang Anak" {{ $article->category == 'Tumbuh Kembang Anak' ? 'selected' : '' }}>Tumbuh Kembang Anak</option>
                            <option value="Gizi & Nutrisi" {{ $article->category == 'Gizi & Nutrisi' ? 'selected' : '' }}>Gizi & Nutrisi</option>
                            <option value="Imunisasi" {{ $article->category == 'Imunisasi' ? 'selected' : '' }}>Imunisasi</option>
                            <option value="Nifas & Menyusui" {{ $article->category == 'Nifas & Menyusui' ? 'selected' : '' }}>Nifas & Menyusui</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
                        <input type="file" name="image" class="form-control rounded-3">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Isi Artikel</label>
                    <textarea name="content" class="form-control rounded-3" rows="10" required>{{ $article->content }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning text-white rounded-pill px-5 fw-bold">Update Artikel</button>
                <a href="{{ route('artikel.index') }}" class="btn btn-link text-secondary text-decoration-none">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection