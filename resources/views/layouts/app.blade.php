<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Pesantren')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root{
            --brand:#1f4b2c; /* hijau header */
            --brand-2:#173a22; /* hijau tua */
            --sidebar-bg:#f0f6f2; /* bg sisi kiri */
            --sidebar-active:#173a22;
            --success:#22c55e; /* hijau notifikasi */
            --danger:#ef4444; /* merah notifikasi */
        }
        body{background:#f7f5f4}
        .header-bar{background:var(--brand); color:#fff}
        .header-bar .brand{display:flex; align-items:center; gap:.75rem}
        .header-bar img{height:42px; width:42px}
        .layout{display:flex; height:calc(100vh - 64px); overflow:hidden}
.sidebar{width:240px; background:var(--sidebar-bg); display:flex; flex-direction:column; border-right:1px solid #e5e7eb; height:100%; overflow-y:auto}
.sidebar .menu{padding:16px; gap:6px; display:flex; flex-direction:column}
.sidebar .menu .item{display:block; padding:10px 12px; border-radius:8px; color:#374151; text-decoration:none; transition:background .2s ease,color .2s ease}
.sidebar .menu .item:hover{background:#e6efe9; color:#111827}
.sidebar .menu .item.active{background:var(--sidebar-active); color:#fff}
.sidebar .menu .title{font-size:.9rem; color:#6b7280; padding:10px 12px}
.sidebar .footer{margin-top:auto; padding:16px; border-top:1px solid #e5e7eb}
.btn-logout{display:flex; align-items:center; justify-content:center; gap:.5rem; width:100%; background:var(--brand-2); color:#fff; border:none; border-radius:8px; padding:10px 12px}
.btn-logout:hover{background:#0f2a19}
.content{flex:1; padding:20px; height:100%; overflow-y:auto}
.card-surface{background:#fff; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,.06)}

        /* Flash notifications */
        .alert-toast{border:none; border-radius:10px; color:#fff; padding:10px 12px; display:flex; align-items:center; gap:.5rem; box-shadow:0 2px 8px rgba(0,0,0,.10)}
        .alert-toast.success{background:var(--success)}
        .alert-toast.error{background:var(--danger)}
        .alert-toast .btn-close{filter:invert(1)}
        .alert-container{position:sticky; top:0; z-index:1020}

         .actions{display:flex; gap:.5rem; justify-content:center}
         .btn-action{display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:8px; border:0}
         .btn-action.view{background:#1f4b2c; color:#fff}
         .btn-action.edit{background:#f59e0b; color:#fff}
         .btn-action.delete{background:#dc2626; color:#fff}
         .pagination{display:flex; gap:.5rem; justify-content:flex-start}
         .pagination .page-item{list-style:none}
         .pagination .page-link{
            display:flex; align-items:center; justify-content:center;
            min-width:40px; height:40px; padding:0 12px;
            border-radius:10px; border:1px solid #e5e7eb;
            background:#fff; color:#374151;
         }
         .pagination .page-link:hover{background:#f3f4f6; color:#111827}
         .pagination .page-item.active .page-link{
            background:#1f4b2c; border-color:#1f4b2c; color:#fff;
         }
         .pagination .page-item.disabled .page-link{
            background:#f1f5f9; color:#9ca3af; border-color:#e5e7eb;
         }
      </style>
</head>
<body>
    <header class="header-bar py-3">
        <div class="container-fluid px-4">
            <div class="brand">
                <img src="/img/logo.png" alt="logo">
                <div>
                    <div class="fw-semibold">PPTQ Bilal bin Rabah Sukoharjo</div>
                    <div class="small opacity-75">@yield('page_title', 'Dashboard')</div>
                </div>
            </div>
        </div>
    </header>

    <div class="layout">
        <aside class="sidebar">
            <div class="menu">
                <div class="title">Menu</div>
                    <a href="{{ route('dashboard') }}" class="item {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('santri.index') }}" class="item {{ request()->routeIs('santri.*') ? 'active' : '' }}">Data Santri</a>
                    <a href="{{ route('matapelajaran.index') }}" class="item {{ request()->routeIs('matapelajaran.*') ? 'active' : '' }}">Mata Pelajaran</a>
                    <a href="{{ route('tahunajaran.index') }}" class="item {{ request()->routeIs('tahunajaran.*') ? 'active' : '' }}">Tahun Ajar</a>
                    <a href="#" class="item">Kelompok Halaqah</a>
                    <a href="#" class="item">Data Pendidik</a>
                    <a href="#" class="item">Nilai Akademik</a>
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
            <div class="card-surface p-3">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // auto-dismiss alert setelah 4 detik
      document.querySelectorAll('.alert.alert-dismissible').forEach(function(el){
        setTimeout(function(){
          try { bootstrap.Alert.getOrCreateInstance(el).close(); } catch(e) {}
        }, 4000);
      });
    </script>
    @stack('scripts')
</body>
</html>