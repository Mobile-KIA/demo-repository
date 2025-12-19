@extends('layout')

@section('content')
<div class="container py-5">

    {{-- 1. HERO SECTION (SAPAAN & INFO JADWAL) --}}
    {{-- Menggunakan Card Putih Besar agar terlihat menyatu dan rapi --}}
    <div class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden">
        <div class="card-body p-0">
            <div class="row g-0">
                
                {{-- KIRI: Sapaan (Background Putih) --}}
                <div class="col-lg-8 p-4 p-md-5 d-flex align-items-center">
                    <div class="me-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 64px; height: 64px;">
                            <i class="bi bi-heart-fill fs-3"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted fw-bold small ls-1 mb-1">Dashboard Bunda</h6>
                        <h2 class="fw-bold text-dark mb-1">Halo, {{ explode(' ', $patient->nama)[0] }}!</h2>
                        <p class="text-secondary mb-0 small">Pantau kesehatan keluarga dengan mudah.</p>
                    </div>
                </div>

                {{-- KANAN: Jadwal (Background Biru Muda - Membedakan Fokus) --}}
                <div class="col-lg-4 bg-primary bg-opacity-10 p-4 p-md-5 d-flex flex-column justify-content-center border-start border-light">
                    <span class="text-uppercase text-primary fw-bold small ls-1 mb-2">
                        <i class="bi bi-calendar-event me-1"></i> Jadwal Kontrol
                    </span>
                    <h3 class="fw-bold text-dark mb-0">{{ $nextVisit->format('d M Y') }}</h3>
                    <small class="text-muted mt-1">{{ $visitType }}</small>
                </div>

            </div>
        </div>
    </div>


    {{-- 2. MAIN CONTENT (GRID 2 KOLOM SEJAJAR) --}}
    <div class="row g-4 align-items-stretch">
        
        {{-- KOLOM KIRI: STATUS KEHAMILAN --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom border-light pt-4 px-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-dark mb-0">Status Kehamilan</h6>
                        @if($patient->kehamilans->count() > 0)
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">Aktif</span>
                        @endif
                    </div>
                </div>

                <div class="card-body p-4 d-flex flex-column justify-content-center">
                    @if($patient->kehamilans->count() > 0)
                        @php $lastPreg = $patient->kehamilans->last(); @endphp
                        
                        {{-- Angka Utama (Center) --}}
                        <div class="text-center py-2">
                            <span class="display-3 fw-bold text-danger">{{ $lastPreg->usia_kehamilan }}</span>
                            <span class="fs-5 text-secondary fw-medium d-block mt-n2">Minggu</span>
                        </div>

                        {{-- Grid Data Kecil (Rapi dengan Border) --}}
                        <div class="row mt-4 g-0 bg-light rounded-3 border border-light-subtle text-center overflow-hidden">
                            <div class="col-4 py-3 border-end">
                                <small class="text-muted d-block mb-1" style="font-size: 11px;">BERAT BADAN</small>
                                <span class="fw-bold text-dark">{{ $lastPreg->berat_badan }} kg</span>
                            </div>
                            <div class="col-4 py-3 border-end">
                                <small class="text-muted d-block mb-1" style="font-size: 11px;">TINGGI BADAN</small>
                                <span class="fw-bold text-dark">{{ $lastPreg->tinggi_badan }} cm</span>
                            </div>
                            <div class="col-4 py-3">
                                <small class="text-muted d-block mb-1" style="font-size: 11px;">TEKANAN DARAH</small>
                                <span class="fw-bold text-dark">{{ $lastPreg->tekanan_darah }}</span>
                            </div>
                        </div>
                    @else
                        {{-- State Kosong yang Rapi --}}
                        <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex p-3 mb-3 text-secondary">
                                <i class="bi bi-clipboard-x fs-4"></i>
                            </div>
                            <p class="text-muted small mb-0">Data kehamilan tidak tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        {{-- KOLOM KANAN: LIST ANAK --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom border-light pt-4 px-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-dark mb-0">Data Anak</h6>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                            {{ $patient->children->count() }} Anak
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="d-flex flex-column gap-3">
                        @forelse($patient->children as $child)
                            {{-- Item Anak (Card Kecil) --}}
                            <a href="{{ route('ortu.anak.show', $child->id) }}" class="text-decoration-none group-hover">
                                <div class="p-3 rounded-3 border border-light bg-white d-flex align-items-center transition-hover">
                                    
                                    {{-- Avatar --}}
                                    <div class="bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center me-3" 
                                         style="width: 48px; height: 48px;">
                                        <i class="bi bi-emoji-smile fs-5"></i>
                                    </div>

                                    {{-- Teks --}}
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold text-dark mb-1">{{ $child->nama }}</h6>
                                        <div class="d-flex text-secondary small">
                                            <span class="me-3"><i class="bi bi-clock me-1"></i>{{ $child->usia }}</span>
                                            <span><i class="bi bi-gender-ambiguous me-1"></i>{{ $child->jenis_kelamin }}</span>
                                        </div>
                                    </div>

                                    {{-- Arrow Icon --}}
                                    <div class="text-muted opacity-25">
                                        <i class="bi bi-chevron-right"></i>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex p-3 mb-3 text-secondary">
                                    <i class="bi bi-people fs-4"></i>
                                </div>
                                <p class="text-muted small mb-0">Belum ada data anak.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
    

    {{-- 3. ARTIKEL (Grid 3 Kolom Rapi) --}}
    <div class="mt-5">
        <h6 class="fw-bold text-dark mb-4 px-1">Informasi & Edukasi</h6>
        <div class="row g-4">
            @foreach($articles as $article)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                    <div class="card-body p-4 d-flex flex-column">
                        <span class="badge bg-info bg-opacity-10 text-info w-auto align-self-start rounded-pill px-3 py-2 mb-3 small">
                            {{ $article['category'] }}
                        </span>
                        <h6 class="fw-bold text-dark mb-2">{{ $article['title'] }}</h6>
                        <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">{{ $article['desc'] }}</p>
                        <a href="#" class="text-decoration-none fw-bold text-primary small mt-auto">
                            Baca Artikel <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<style>
    /* Styling Tambahan untuk Kerapian */
    
    .ls-1 { letter-spacing: 0.5px; }
    
    /* Efek Hover Halus pada Card Anak & Artikel */
    .transition-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    
    .group-hover:hover .transition-hover,
    .card.transition-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        border-color: #e9ecef !important;
    }

    /* Memastikan tinggi card sama */
    .h-100 { height: 100%; }
</style>
@endsection