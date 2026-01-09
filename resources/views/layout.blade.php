<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi KIA</title>
    
    {{-- Bootstrap 5 & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            overflow-x: hidden;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        /* --- SIDEBAR STYLING --- */
        #wrapper { display: flex; width: 100%; transition: all 0.4s ease-in-out; }
        
        #sidebar-wrapper {
            min-height: 100vh;
            width: 14rem;
            margin-left: 0;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: #ffffff;
            border-right: 1px solid rgba(0,0,0,0.05);
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
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        #sidebarToggle {
            background: rgba(0, 0, 0, 0.03);
            border: none;
            color: #495057;
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            transition: 0.3s;
        }
        #sidebarToggle:hover { background: rgba(214, 51, 132, 0.1); color: #d63384; }

        .list-group-item {
            border: none;
            padding: 0.9rem 1.5rem;
            display: flex; align-items: center;
            font-weight: 500;
            color: #495057;
            transition: all 0.2s;
        }
        .list-group-item:hover { background-color: rgba(214, 51, 132, 0.05); color: #d63384; padding-left: 1.8rem; }
        .list-group-item.active {
            background: linear-gradient(90deg, rgba(214, 51, 132, 0.15) 0%, transparent 100%);
            color: #d63384;
            font-weight: 700;
            border-left: 4px solid #d63384;
        }

        .menu-header { color: #adb5bd; font-size: 0.75rem; letter-spacing: 1px; font-weight: 700; }
        .sidebar-footer { padding: 1rem; margin-top: auto; border-top: 1px solid rgba(0,0,0,0.05); }

        .profile-card {
            background: white;
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 12px;
            padding: 10px;
            display: flex; align-items: center;
            cursor: pointer; transition: 0.3s;
        }
        .profile-card:hover { transform: translateY(-2px); border-color: #d63384; }

        /* --- CONTENT AREA --- */
        #page-content-wrapper { width: 100%; margin-left: 14rem; transition: all 0.4s; min-height: 100vh; }

        /* --- LOGIC MINI SIDEBAR (TOGGLED) --- */
        #wrapper.toggled #sidebar-wrapper { width: 5.5rem; }
        #wrapper.toggled #page-content-wrapper { margin-left: 5.5rem; }
        #wrapper.toggled .sidebar-text, #wrapper.toggled .sidebar-brand-text, #wrapper.toggled .profile-text, #wrapper.toggled .menu-header { display: none; }
        #wrapper.toggled .sidebar-heading { justify-content: center; padding: 0; }
        #wrapper.toggled #sidebarToggle { display: none; }
        #wrapper.toggled .logo-icon { margin-right: 0 !important; }
        #wrapper.toggled .list-group-item { padding-left: 1.5rem; justify-content: center; }
        #wrapper.toggled .list-group-item:hover { padding-left: 1.5rem; }
        #wrapper.toggled .list-group-item i { text-align: center; }
        #wrapper.toggled .profile-card { justify-content: center; border: none; }

        @media (max-width: 768px) {
            #sidebar-wrapper { margin-left: -14rem; }
            #page-content-wrapper { margin-left: 0; }
            #wrapper.toggled #sidebar-wrapper { margin-left: 0; width: 14rem; }
            #wrapper.toggled .logo-icon { margin-right: 1rem !important; }
            #wrapper.toggled .sidebar-brand-text { display: block; }
            #wrapper.toggled #sidebarToggle { display: flex; }
        }
    </style>
</head>

<body>

    @auth
        <div id="wrapper">
            {{-- PANGGIL SIDEBAR PARTIAL --}}
            @include('partials.sidebar')

            {{-- KONTEN HALAMAN --}}
            <div id="page-content-wrapper">
                
                {{-- Toggle Mobile Header --}}
                <div class="d-md-none p-3 bg-white border-bottom shadow-sm mb-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-light border me-3" onclick="toggleMenu()">
                            <i class="bi bi-list fs-4"></i>
                        </button>
                        <span class="fw-bold fs-5">Menu</span>
                    </div>
                </div>

                <div class="container-fluid py-4 px-4">
                    @yield('content')
                </div>
            </div>
        </div>
    @endauth

    @guest
        <div class="container py-5">
            @yield('content')
        </div>
    @endguest

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi Toggle Sidebar
        function toggleMenu() {
            const wrapper = document.getElementById('wrapper');
            if (wrapper) wrapper.classList.toggle('toggled');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.getElementById('wrapper');

            // Logic Auto Open/Close saat klik profile
            const profileTrigger = document.querySelector('.profile-card');
            if (profileTrigger && wrapper) {
                profileTrigger.addEventListener('click', function() {
                    if (wrapper.classList.contains('toggled')) wrapper.classList.remove('toggled');
                });
            }

            // Logic Mobile Auto Close saat klik menu
            const isMobile = window.innerWidth <= 768;
            const menuLinks = document.querySelectorAll('.list-group-item');
            if(isMobile) {
                menuLinks.forEach(link => {
                    link.addEventListener('click', () => {
                         if(wrapper.classList.contains('toggled')) wrapper.classList.remove('toggled');
                    });
                });
            }
        });
    </script>
</body>
</html>