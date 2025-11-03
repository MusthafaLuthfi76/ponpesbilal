@extends('layouts.app')

@section('page_title','Data Santri')

@section('content')
<style>
:root { 
    --green:#1f4a34; 
    --green2:#305d47; 
    --panel:#e3ede6; 
    --bg:#cdd9cf; 
    --card-bg:#2b5d45;
    --card-bg-dark:#1c3f2d;
    --primary-text:#0f1b14;
    --secondary-text:#1b3126;
    --accent-color:#cfe9d7;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
}

body {
    background: var(--bg);
    color: var(--primary-text);
    line-height: 1.6;
}

/* === MAIN CONTENT === */
.content {
    padding: 30px;
    background: var(--panel);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    width: 100%;
}

/* === WELCOME BOX === */
.welcome {
    background: #e6f3ea;
    color: var(--secondary-text);
    border: 1px solid #d7e5dc;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 24px;
    font-weight: 600;
}

/* === DASHBOARD CARD GRID === */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
}

.card {
    background: linear-gradient(180deg, var(--card-bg) 0%, var(--card-bg-dark) 100%);
    color: #fff;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card .value {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 12px;
}

.card .label {
    font-size: 16px;
    opacity: 0.85;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .grid {
        grid-template-columns: 1fr;
    }
}
</style>

<main class="content">
    <div class="welcome">
        Assalamu'alaikum warahmatullahi wabarakatuh. Selamat datang di Sistem Informasi Pesantren Bilal bin Rabah.
    </div>

    <div class="grid">
        <div class="card">
            <div class="value">{{ $stats['santri_ma'] }}</div>
            <div class="label">Total Santri MA</div>
        </div>
        <div class="card">
            <div class="value">{{ $stats['santri_mts'] }}</div>
            <div class="label">Total Santri MTS</div>
        </div>
        <div class="card">
            <div class="value">{{ $stats['alumni'] }}</div>
            <div class="label">Alumni</div>
        </div>
        <div class="card">
            <div class="value">{{ $stats['mata_pelajaran'] }}</div>
            <div class="label">Jumlah Mata Pelajaran</div>
        </div>
    </div>
</main>
@endsection
