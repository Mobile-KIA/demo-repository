@extends('layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <a href="{{ route('dashboard.orangtua') }}" class="btn btn-light border rounded-pill mb-4 shadow-sm">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
            </a>

            <article>
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3">
                    {{ $article->category }}
                </span>
                
                <h1 class="fw-bold mb-3 display-5">{{ $article->title }}</h1>
                
                <div class="text-muted mb-4 small">
                    <i class="bi bi-calendar-event me-2"></i> {{ $article->created_at->format('d F Y') }}
                </div>

                <img src="{{ $article->image_url }}" class="img-fluid w-100 rounded-4 mb-5 shadow-sm" alt="{{ $article->title }}">

                <div class="article-content lh-lg text-dark" style="font-size: 1.1rem; text-align: justify;">
                    {{-- Menampilkan isi artikel dengan format paragraf --}}
                    {!! nl2br(e($article->content)) !!}
                </div>
            </article>

            <hr class="my-5">

            @if($relatedArticles->count() > 0)
                <h5 class="fw-bold mb-4">Bacaan Terkait</h5>
                <div class="row g-3">
                    @foreach($relatedArticles as $related)
                        <div class="col-md-4">
                            <a href="{{ route('artikel.baca', $related->slug) }}" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm hover-shadow rounded-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-dark mb-2">{{ $related->title }}</h6>
                                        <small class="text-muted">Baca selengkapnya <i class="bi bi-arrow-right"></i></small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
@endsection