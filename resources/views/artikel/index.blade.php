@extends('layout')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Manajemen Edukasi</h3>
        <a href="{{ route('artikel.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Tulis Artikel
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        @foreach($articles as $article)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                <div style="height: 200px; background-image: url('{{ $article->image_url }}'); background-size: cover; background-position: center;"></div>
                
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill">{{ $article->category }}</span>
                        <small class="text-muted">{{ $article->created_at->format('d M Y') }}</small>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ $article->title }}</h5>
                    <p class="text-secondary small text-truncate">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                    
                    <div class="mt-auto d-flex gap-2 pt-3 border-top">
                        <a href="{{ route('artikel.edit', $article->id) }}" class="btn btn-light btn-sm rounded-pill px-3 text-primary fw-bold">Edit</a>
                        
                        <form action="{{ route('artikel.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-light text-danger btn-sm rounded-pill px-3">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection