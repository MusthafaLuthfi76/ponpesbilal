<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Pesantren')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --brand:#1f4b2c;
            --brand-2:#173a22;
            --sidebar-bg:#f0f6f2;
            --sidebar-active:#173a22;
            --success:#22c55e;
            --danger:#ef4444;
        }

        body {
            background:#f7f5f4;
            margin:0;
            font-family: 'Inter', sans-serif;
        }

        /* HEADER */
        .header-bar {
            background:var(--brand);
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:.75rem 1rem;
        }
        .header-bar .brand {
            display:flex;
            align-items:center;
            gap:.75rem;
        }
        .header-bar img {
            height:42px;
            width:42px;
        }

        /* MENU TOGGLE (MOBILE) */
        .menu-toggle {
            background:none;
            border:none;
            color:#fff;
            font-size:1.5rem;
            display:none;
        }

        /* LAYOUT */
        .layout {
            display:flex;
            height:calc(100vh - 64px);
            overflow:hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width:240px;
            background:var(--sidebar-bg);
            display:flex;
            flex-direction:column;
            border-right:1px solid #e5e7eb;
            height:100%;
            overflow-y:auto;
            transition:all .3s ease;
        }
        .sidebar .menu {
            padding:16px;
            gap:6px;
            display:flex;
            flex-direction:column;
        }
        .sidebar .menu .item {
            display:block;
            padding:10px 12px;
            border-radius:8px;
            color:#374151;
            text-decoration:none;
            transition:background .2s ease,color .2s ease;
        }
        .sidebar .menu .item:hover {
            background:#e6efe9;
            color:#111827;
        }
        .sidebar .menu .item.active {
            background:var(--sidebar-active);
            color:#fff;
        }
        .sidebar .menu .title {
            font-size:.9rem;
            color:#6b7280;
            padding:10px 12px;
        }
        .sidebar .footer {
            margin-top:auto;
            padding:16px;
            border-top:1px solid #e5e7eb;
        }
        .btn-logout {
            display:flex;
            align-items:center;
            justify-content:center;
            gap:.5rem;
            width:100%;
            background:var(--brand-2);
            color:#fff;
            border:none;
            border-radius:8px;
            padding:10px 12px;
        }
        .btn-logout:hover { background:#0f2a19; }

        /* KONTEN */
        .content {
            flex:1;
            padding:20px;
            height:100%;
            overflow-y:auto;
            background:#f7f5f4;
        }
        .card-surface {
            background:#fff;
            border-radius:12px;
            box-shadow:0 1px 6px rgba(0,0,0,.06);
            padding:20px;
            min-height:calc(100vh - 120px);
        }

        /* ALERT */
        .alert-toast {
            border:none;
            border-radius:10px;
            color:#fff;
            padding:10px 12px;
            display:flex;
            align-items:center;
            gap:.5rem;
            box-shadow:0 2px 8px rgba(0,0,0,.10);
        }
        .alert-toast.success { background:var(--success); }
        .alert-toast.error { background:var(--danger); }
        .alert-toast .btn-close { filter:invert(1); }
        .alert-container {
            position:sticky;
            top:0;
            z-index:1020;
        }
        /* Overlay belakang sidebar */
        .sidebar-overlay {
            display:none;
            position:fixed;
            top:0; left:0;
            width:100%; height:100%;
            background:rgba(0,0,0,0.4);
            z-index:1040;
            transition:opacity .3s ease;
            opacity:0;
        }
        .sidebar-overlay.show {
            display:block;
            opacity:1;
        }


        /* RESPONSIVE */
        @media (max-width: 992px) {
            .menu-toggle { display:block; }
            .sidebar {
                position:fixed;
                top:0; left:-260px;
                width:240px;
                height:100vh;
                z-index:1050;
                background:var(--sidebar-bg);
                box-shadow:2px 0 6px rgba(0,0,0,0.1);
                transition:left .3s ease;
            }
            .sidebar.show {
                left:0;
            }
            .layout {
                flex-direction:column;
                height:auto;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="header-bar">
        <div class="brand">
            <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
            <img src="/img/logo.png" alt="logo">
            <div>
                <div class="fw-semibold">PPTQ Bilal bin Rabah Sukoharjo</div>
                <div class="small opacity-75">@yield('page_title', 'Dashboard')</div>
            </div>
        </div>
    </header>

    <!-- LAYOUT -->
    <div class="layout">
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="menu">
                <div class="title">Menu</div>
                <a href="{{ route('dashboard') }}" class="item {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('santri.index') }}" class="item {{ request()->routeIs('santri.*') ? 'active' : '' }}">Data Santri</a>
                <a href="{{ route('matapelajaran.index') }}" class="item {{ request()->routeIs('matapelajaran.*') ? 'active' : '' }}">Mata Pelajaran</a>
                <a href="{{ route('tahunajaran.index') }}" class="item {{ request()->routeIs('tahunajaran.*') ? 'active' : '' }}">Tahun Ajar</a>
                <a href="#" class="item">Kelompok Halaqah</a>
                <a href="{{ route('pendidik.index') }}" class="item {{ request()->routeIs('pendidik.*') ? 'active' : '' }}">Data Pendidik</a>
                <a href="{{ route('nilaiakademik.index') }}" class="item {{ request()->routeIs('nilaiakademik.*') ? 'active' : '' }}">Nilai Akademik</a>
                <a href="#" class="item">Nilai Tahfidz</a>
                <a href="#" class="item">Nilai Kesantrian</a>
                <a href="#" class="item">Laporan & Rapor</a>
            </div>
            <div class="footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </aside>
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- KONTEN -->
        <main class="content">
            <div class="alert-container">
                @if(session('success'))
                    <div class="alert alert-dismissible fade show alert-toast success" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-dismissible fade show alert-toast error" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="card-surface">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alert
        document.querySelectorAll('.alert.alert-dismissible').forEach(function(el){
            setTimeout(() => { bootstrap.Alert.getOrCreateInstance(el).close(); }, 4000);
        });

        // Sidebar toggle (mobile)
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        menuToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    </script>
    @stack('scripts')
</body>
</html>
