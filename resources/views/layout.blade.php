<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi KIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            overflow-x: hidden;
            font-family: 'Segoe UI', sans-serif;
            transition: background-color 0.3s;
        }

        /* --- TEMA WARNA DINAMIS --- */
        :root {
            /* Light Mode */
            --sidebar-bg: rgba(255, 255, 255, 0.85);
            --sidebar-border: rgba(0, 0, 0, 0.05);
            --text-main: #495057;
            --text-hover: #d63384;
            --hover-bg: rgba(214, 51, 132, 0.05);
            --profile-card-bg: white;
            --profile-card-border: rgba(0, 0, 0, 0.05);
            --profile-hover: #fff0f6;
        }

        [data-bs-theme="dark"] {
            /* Dark Mode */
            --sidebar-bg: rgba(33, 37, 41, 0.95);
            --sidebar-border: rgba(255, 255, 255, 0.1);
            --text-main: #e9ecef;
            --text-hover: #ff85c0;
            --hover-bg: rgba(255, 255, 255, 0.1);
            --profile-card-bg: #2b3035;
            --profile-card-border: rgba(255, 255, 255, 0.1);
            --profile-hover: #343a40;
        }

        #wrapper {
            display: flex;
            width: 100%;
            transition: all 0.4s ease-in-out;
        }

        /* SIDEBAR STYLING */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 14rem;
            /* UBAH DARI 17.5rem KE 14rem */
            margin-left: 0;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            color: var(--text-main);
            position: fixed;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-heading {
            padding: 0 1.5rem;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--sidebar-border);
            cursor: pointer;
        }

        #sidebarToggle {
            background: rgba(0, 0, 0, 0.03);
            border: none;
            color: var(--text-main);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        #sidebarToggle:hover {
            background: rgba(214, 51, 132, 0.1);
            color: #d63384;
        }

        [data-bs-theme="dark"] #sidebarToggle {
            background: rgba(255, 255, 255, 0.1);
        }

        .list-group-item {
            background-color: transparent;
            color: var(--text-main);
            border: none;
            padding: 0.9rem 1.5rem;
            display: flex;
            align-items: center;
            margin-bottom: 2px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .list-group-item:hover {
            background-color: var(--hover-bg);
            color: var(--text-hover);
            padding-left: 1.8rem;
        }

        .list-group-item.active {
            background: linear-gradient(90deg, rgba(214, 51, 132, 0.15) 0%, transparent 100%);
            color: #d63384;
            font-weight: 700;
            border-left: 4px solid #d63384;
        }

        [data-bs-theme="dark"] .list-group-item.active {
            color: #ff85c0;
        }

        .list-group-item i {
            font-size: 1.25rem;
            min-width: 3rem;
            text-align: left;
            transition: 0.3s;
        }

        .menu-header {
            color: var(--text-main);
            opacity: 0.6;
            font-size: 0.75rem;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .sidebar-footer {
            padding: 1rem;
            margin-top: auto;
            border-top: 1px solid var(--sidebar-border);
        }

        .profile-card {
            background: var(--profile-card-bg);
            border: 1px solid var(--profile-card-border);
            border-radius: 12px;
            padding: 10px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .profile-card:hover {
            transform: translateY(-2px);
            background-color: var(--profile-hover);
            border-color: #d63384;
        }

        /* CONTENT AREA */
        #page-content-wrapper {
            width: 100%;
            margin-left: 14rem;
            transition: all 0.4s;
            min-height: 100vh;
        }

        /* LOGIC MINI SIDEBAR */
        #wrapper.toggled #sidebar-wrapper {
            width: 5.5rem;
        }

        #wrapper.toggled #page-content-wrapper {
            margin-left: 5.5rem;
        }

        #wrapper.toggled .sidebar-text,
        #wrapper.toggled .sidebar-brand-text,
        #wrapper.toggled .profile-text,
        #wrapper.toggled .menu-header {
            opacity: 0;
            pointer-events: none;
            display: none;
        }

        #wrapper.toggled .sidebar-heading {
            justify-content: center;
            padding: 0;
        }

        #wrapper.toggled #sidebarToggle {
            display: none;
        }

        #wrapper.toggled .logo-icon {
            margin-right: 0 !important;
        }

        #wrapper.toggled .list-group-item {
            padding-left: 1.5rem;
            justify-content: center;
        }

        #wrapper.toggled .list-group-item:hover {
            padding-left: 1.5rem;
            background: var(--hover-bg);
        }

        #wrapper.toggled .list-group-item i {
            min-width: 0;
            text-align: center;
        }

        #wrapper.toggled .profile-card {
            justify-content: center;
            background: transparent;
            border: none;
            box-shadow: none;
        }

        #wrapper.toggled .profile-card:hover {
            background: var(--hover-bg);
        }

        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: -14rem;
            }

            #page-content-wrapper {
                margin-left: 0;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
                width: 14rem;
            }

            #wrapper.toggled .logo-icon {
                margin-right: 1rem !important;
            }

            #wrapper.toggled .sidebar-brand-text {
                display: block;
                opacity: 1;
            }

            #wrapper.toggled #sidebarToggle {
                display: flex;
            }
        }
    </style>
</head>

<body>

    {{-- LOGIC 1: JIKA USER SUDAH LOGIN (Tampilkan Sidebar & Dashboard) --}}
    @auth
        <div id="wrapper">
            <div id="sidebar-wrapper">
                <div class="sidebar-heading"
                    onclick="if(document.getElementById('wrapper').classList.contains('toggled')) toggleMenu()">
                    <div class="d-flex align-items-center overflow-hidden">
                        <div class="logo-icon bg-danger bg-gradient rounded-4 d-flex align-items-center justify-content-center shadow-sm me-3"
                            style="width: 38px; height: 38px; min-width: 38px;">
                            <i class="bi bi-heart-pulse-fill text-white fs-5"></i>
                        </div>
                        <span class="fw-bold fs-5 sidebar-brand-text tracking-wide">KIA App</span>
                    </div>
                    <button id="sidebarToggle" onclick="event.stopPropagation(); toggleMenu();">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                </div>

                <div class="list-group list-group-flush flex-grow-1 overflow-auto py-4">
                    <a href="{{ auth()->user()->role == 'Tenaga Medis' ? route('dashboard.tenagamedis') : route('dashboard.orangtua') }}"
                        class="list-group-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i> <span class="sidebar-text ms-3">Dashboard</span>
                    </a>

                    @if(auth()->user()->role == 'Tenaga Medis')
                        <div class="small text-uppercase px-4 mt-4 mb-2 menu-header">Pasien</div>
                        <a href="{{ route('pasien.index') }}"
                            class="list-group-item {{ request()->is('pasien*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> <span class="sidebar-text ms-3">Data Pasien</span>
                        </a>
                        <a href="{{ route('rm.index') }}"
                            class="list-group-item {{ request()->routeIs('rekam-medis.menu') ? 'active' : '' }}">
                            <i class="bi bi-journal-medical"></i> <span class="sidebar-text ms-3">Rekam Medis</span>
                        </a>
                        <div class="small text-uppercase px-4 mt-4 mb-2 menu-header">Layanan</div>
                        <a href="#" class="list-group-item"><i class="bi bi-calendar-check"></i> <span
                                class="sidebar-text ms-3">Jadwal</span></a>
                        <a href="#" class="list-group-item"><i class="bi bi-book-half"></i> <span
                                class="sidebar-text ms-3">Edukasi</span></a>
                    @endif

                    @if(auth()->user()->role == 'Orang Tua')
                        <div class="small text-uppercase px-4 mt-4 mb-2 menu-header">Menu Bunda</div>
                        <a href="#" class="list-group-item"><i class="bi bi-clipboard-heart"></i> <span
                                class="sidebar-text ms-3">Kesehatan Saya</span></a>
                    @endif
                </div>

                <div class="sidebar-footer">
                    <div class="dropdown dropup w-100">
                        <div class="profile-card" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 36px; height: 36px;">
                                <span class="fw-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <div class="ms-3 profile-text overflow-hidden">
                                <div class="fw-bold text-truncate" style="font-size: 0.9rem;">
                                    {{ explode(' ', auth()->user()->name)[0] }}
                                </div>
                                <div class="opacity-75 small" style="font-size: 0.75rem;">{{ auth()->user()->role }}</div>
                            </div>
                        </div>

                        <ul class="dropdown-menu shadow-lg border-0 rounded-4 w-100 mb-2 p-2">
                            <li>
                                <h6 class="dropdown-header">Pengaturan</h6>
                            </li>
                            <li>
                                <button class="dropdown-item rounded-2 d-flex align-items-center" type="button"
                                    onclick="event.stopPropagation(); toggleTheme();">
                                    <i class="bi bi-moon-stars me-2" id="themeIcon"></i>
                                    <span id="themeText">Dark Mode</span>
                                </button>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item rounded-2" href="{{ route('profile.edit') }}"><i
                                        class="bi bi-person me-2"></i> Profile Saya</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item rounded-2 text-danger fw-bold d-flex align-items-center">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="page-content-wrapper">
                <div
                    class="d-md-none p-3 bg-white border-bottom shadow-sm mb-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-light border me-3" onclick="toggleMenu()"><i
                                class="bi bi-list fs-4"></i></button>
                        <span class="fw-bold fs-5">Menu</span>
                    </div>
                </div>
                <div class="container-fluid py-4 px-4">
                    @yield('content')
                </div>
            </div>
        </div>
    @endauth

    {{-- LOGIC 2: JIKA USER BELUM LOGIN (Login/Register Only) --}}
    @guest
        <div class="container py-5">
            @yield('content')
        </div>
    @endguest

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 1. FUNGSI TOGGLE SIDEBAR (Manual via Tombol Hamburger)
        function toggleMenu() {
            const wrapper = document.getElementById('wrapper');
            if (wrapper) {
                wrapper.classList.toggle('toggled');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.getElementById('wrapper');

            // ---------------------------------------------------------
            // 2. FITUR BARU: AUTO OPEN SAAT KLIK PROFILE
            // ---------------------------------------------------------
            const profileTrigger = document.querySelector('.profile-card');
            
            if (profileTrigger && wrapper) {
                profileTrigger.addEventListener('click', function() {
                    // Cek: Apakah sidebar sedang mengecil (ada class 'toggled')?
                    if (wrapper.classList.contains('toggled')) {
                        // Jika ya, HAPUS class tersebut agar sidebar membesar
                        wrapper.classList.remove('toggled');
                    }
                });
            }
            // ---------------------------------------------------------


            // 3. LOGIC MOBILE: AUTO CLOSE SAAT KLIK MENU
            const isMobile = window.innerWidth <= 768;
            const menuLinks = document.querySelectorAll('.list-group-item');
            
            if(isMobile) {
                menuLinks.forEach(link => {
                    link.addEventListener('click', () => {
                         if(wrapper.classList.contains('toggled')) {
                             wrapper.classList.remove('toggled'); // Di mobile logicnya terbalik (toggled = open)
                         } else {
                             // Jika di desktop logicnya beda, sesuaikan jika perlu
                         }
                    });
                });
            }

            // 4. LOGIC THEME (DARK/LIGHT MODE)
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            updateThemeUI(savedTheme);
        });

        // Helper Function untuk Theme
        function toggleTheme() {
            const htmlElement = document.documentElement;
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            htmlElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeUI(newTheme);
        }

        function updateThemeUI(theme) {
            const icon = document.getElementById('themeIcon');
            const text = document.getElementById('themeText');
            if (icon && text) {
                if (theme === 'dark') {
                    icon.className = 'bi bi-sun-fill me-2';
                    text.textContent = 'Light Mode';
                } else {
                    icon.className = 'bi bi-moon-stars me-2';
                    text.textContent = 'Dark Mode';
                }
            }
        }
    </script>
</body>

</html>