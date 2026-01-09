@php
    /** @var \App\Models\User $user */
    $user = auth()->user();
    
    // Warna Tema Utama (Bisa diganti hex-nya)
    $themeColor = '#ff4b6a'; 
@endphp

<style>
    /* --- CSS KHUSUS SIDEBAR VERSI PREMIUM --- */
    #sidebar-wrapper {
        background: #ffffff;
        border-right: 1px solid #f0f0f0;
        box-shadow: 4px 0 24px rgba(0,0,0,0.02); /* Bayangan sangat halus */
    }

    /* Header Logo */
    .brand-logo {
        background: linear-gradient(135deg, {{ $themeColor }} 0%, #ff758c 100%);
        box-shadow: 0 4px 15px rgba(255, 75, 106, 0.3);
    }

    /* Menu Item Style */
    .menu-link {
        color: #64748b; /* Warna teks abu-abu modern */
        font-weight: 500;
        padding: 12px 20px;
        margin-bottom: 8px;
        border-radius: 12px; /* Sudut membulat */
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        text-decoration: none;
        border: 1px solid transparent;
    }

    /* Hover State */
    .menu-link:hover {
        background-color: #fff0f3; /* Pink sangat muda */
        color: {{ $themeColor }};
        transform: translateX(4px); /* Efek geser kanan */
    }
    
    .menu-link:hover i {
        transform: scale(1.1); /* Ikon membesar sedikit */
    }

    /* Active State (Menu yang sedang dibuka) */
    .menu-link.active {
        background: linear-gradient(90deg, #fff0f3 0%, #ffffff 100%);
        color: {{ $themeColor }};
        border-left: 4px solid {{ $themeColor }};
        font-weight: 700;
        box-shadow: 0 2px 12px rgba(255, 75, 106, 0.08);
    }

    .menu-link i {
        font-size: 1.2rem;
        width: 28px;
        transition: transform 0.2s ease;
    }

    /* Header Kategori (Kecil) */
    .menu-header-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #94a3b8;
        font-weight: 700;
        margin: 20px 0 10px 20px;
    }

    /* Profile Card di Bawah */
    .user-profile-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .user-profile-card:hover {
        background: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-color: {{ $themeColor }};
        transform: translateY(-3px);
    }
</style>

<div id="sidebar-wrapper">
    
    {{-- 1. HEADER LOGO --}}
    <div class="sidebar-heading my-2">
        <div class="d-flex align-items-center">
            <div class="brand-logo rounded-4 d-flex align-items-center justify-content-center me-3 text-white"
                style="width: 42px; height: 42px; min-width: 42px;">
                <i class="bi bi-heart-pulse-fill fs-5"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-dark tracking-tight">Buku KIA</h5>
            </div>
        </div>
        
        {{-- Tombol Tutup Sidebar (Mobile) --}}
        <button class="btn btn-sm btn-light border-0 d-md-none ms-auto text-muted" onclick="toggleMenu()">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    {{-- 2. LIST MENU --}}
    <div class="d-flex flex-column flex-grow-1 overflow-auto px-3 py-3">
        
        {{-- === MENU UTAMA === --}}
        <div class="menu-header-label">Utama</div>

        {{-- Dashboard Link (Logic Role) --}}
        <a href="{{ $user->role == 'Tenaga Medis' ? route('dashboard.tenagamedis') : route('dashboard.orangtua') }}"
            class="menu-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
            <i class="bi bi-grid-fill me-2"></i>
            <span>Dashboard</span>
        </a>

        {{-- === KHUSUS TENAGA MEDIS === --}}
        @if($user->role == 'Tenaga Medis')
            <div class="menu-header-label">Administrasi</div>
            
            <a href="{{ route('pasien.index') }}" class="menu-link {{ request()->routeIs('pasien.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-2"></i>
                <span>Data Pasien</span>
            </a>
            
            <a href="{{ route('rekam_medis.index') }}" class="menu-link {{ request()->routeIs('rekam_medis.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard2-pulse-fill me-2"></i>
                <span>Rekam Medis</span>
            </a>

            <div class="menu-header-label">Layanan</div>
            
            <a href="{{ route('jadwal.index') }}" class="menu-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-week-fill me-2"></i>
                <span>Jadwal Kontrol</span>
            </a>
            
            <a href="{{ route('artikel.index') }}" class="menu-link {{ request()->routeIs('artikel.*') ? 'active' : '' }}">
                <i class="bi bi-book-half me-2"></i>
                <span>Edukasi</span>
            </a>
        @endif

        {{-- === KHUSUS ORANG TUA === --}}
        @if($user->role == 'Orang Tua')
            <div class="menu-header-label">Menu Bunda</div>
            <a href="#" class="menu-link">
                <i class="bi bi-journal-heart-fill me-2"></i>
                <span>Kesehatan Saya</span>
            </a>
            <a href="#" class="menu-link">
                <i class="bi bi-person-badge-fill me-2"></i>
                <span>Data Anak</span>
            </a>
        @endif

    </div>

    {{-- 3. FOOTER PROFILE (Desain Card Mengambang) --}}
    <div class="p-3 mt-auto">
        <div class="dropdown dropup w-100">
            
            {{-- Tombol Trigger Profile --}}
            <div class="user-profile-card d-flex align-items-center cursor-pointer" data-bs-toggle="dropdown">
                <div class="position-relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ff4b6a&color=fff&rounded=true" 
                         alt="User" class="rounded-circle" width="40" height="40">
                    {{-- Status Online Dot --}}
                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle"></span>
                </div>
                
                <div class="ms-3 overflow-hidden">
                    <h6 class="fw-bold mb-0 text-dark text-truncate" style="font-size: 14px;">
                        {{ explode(' ', $user->name)[0] }}
                    </h6>
                    <small class="text-muted d-block text-truncate" style="font-size: 11px;">
                        {{ $user->role }}
                    </small>
                </div>
                
                <i class="bi bi-chevron-up ms-auto text-muted small"></i>
            </div>

            {{-- Dropdown Menu --}}
            <ul class="dropdown-menu shadow-lg border-0 rounded-4 w-100 mb-2 p-2">
                <li><h6 class="dropdown-header text-uppercase small fw-bold">Akun Saya</h6></li>
                <li><a class="dropdown-item rounded-2 py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear me-2"></i> Edit Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item rounded-2 text-danger fw-bold py-2 d-flex align-items-center">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>