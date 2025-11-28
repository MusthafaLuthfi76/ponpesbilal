<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Progress Hafalan Santri</title>

<style>
/* ===================== */
/* ==== CSS PROGRESS ==== */
/* ===================== */

body {
  margin: 0;
  font-family: "Poppins", sans-serif;
  background: #f8f9fa;
  color: #1a1a1a;
}

/* Header */
.progress-header {
  background: linear-gradient(135deg, #3CA27B 0%, #2d8a64 100%);
  color: white;
  padding: 6rem 0 3rem;
  text-align: center;
}

.progress-header h1 {
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 700;
  margin: 0;
}

.progress-header p {
  margin-top: 0.5rem;
  opacity: 0.9;
}

/* Container */
.progress-container {
  padding: 4rem 2rem;
  max-width: 1200px;
  margin: auto;
}

/* Search Card */
.search-card {
  max-width: 700px;
  margin: 0 auto;
  background: #fff;
  padding: 3rem 2rem;
  text-align: center;
  border-radius: 16px;
  border: 2px solid #e0e0e0;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.search-icon-wrapper {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #3CA27B, #2d8a64);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: auto;
}

.search-icon {
  width: 40px;
  height: 40px;
  color: white;
}

.search-card h2 {
  margin-top: 1.5rem;
  font-weight: 700;
}

.search-subtitle {
  color: #666;
}

/* INPUT GROUP */
.search-input-group {
  display: flex;
  gap: 1rem;
  width: 100%;
  margin-top: 1.5rem;
}

.search-input {
  flex: 1;
  padding: 1.2rem 1.5rem;
  border: 2px solid #e0e0e0;
  border-radius: 12px;
  font-size: 1rem;
}

.search-button {
  background: #3CA27B;
  color: white;
  padding: 1.2rem 2rem;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  font-weight: 600;
}

.search-button:hover {
  background: #318b69;
}

/* Search Results */
.search-results {
  margin-top: 3rem;
}

.results-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
  gap: 1.5rem;
}

.result-card {
  background: white;
  border: 2px solid #e0e0e0;
  padding: 1.5rem;
  border-radius: 12px;
  text-decoration: none;
  color: #1a1a1a;
  transition: 0.3s;
}

.result-card:hover {
  border-color: #3CA27B;
  transform: translateY(-3px);
}

/* Student Detail */
.student-details {
  margin-top: 4rem;
}

.profile-card {
  background: #fff;
  padding: 2rem;
  border-radius: 16px;
  border: 2px solid #e0e0e0;
  margin-bottom: 2rem;
}

.profile-info h2 {
  margin: 0;
  font-size: 2rem;
}

.profile-details span {
  margin-right: 1rem;
  color: #666;
}

/* Summary Cards */
.summary-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
  gap: 1.5rem;
  margin-bottom: 3rem;
}

.summary-card {
  background: #fff;
  padding: 2rem;
  text-align: center;
  border-radius: 16px;
  border: 2px solid #e0e0e0;
}

.summary-value {
  font-size: 2.5rem;
  font-weight: 800;
}

/* Timeline */
.timeline-item {
  background: white;
  border: 2px solid #e0e0e0;
  border-radius: 12px;
  padding: 1.5rem;
  margin-bottom: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
  .search-input-group {
    flex-direction: column;
  }
}
</style>

</head>
<body>

<!-- HEADER -->
<div class="progress-header">
  <h1>Cek Progress Hafalan</h1>
  <p>Orang tua dapat memantau perkembangan hafalan santri secara realtime</p>
</div>

<!-- CONTAINER -->
<div class="progress-container">
<div class="top-back-wrapper">
  <a href="{{ route('landing') }}" class="back-button">← Kembali</a>
</div>


  <!-- SEARCH BOX -->
  <div class="search-card">
    <form method="GET" action="{{ route('progress.search') }}">

      <div class="search-icon-wrapper">
        <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
        </svg>
      </div>

      <h2>Cari Data Hafalan</h2>
      <p class="search-subtitle">Masukkan Nama atau NIS Santri</p>

      <div class="search-input-group">
        <input type="text" name="q" class="search-input" placeholder="Contoh: Ahmad / 2023011" required>
        <button class="search-button">Cari</button>
      </div>
    </form>
  </div>

  <!-- HASIL -->
  @isset($results)
    <div class="search-results">
      <h3>Hasil Pencarian</h3>
      <div class="results-grid">
        @foreach($results as $s)
          <a href="{{ route('progress.show', $s->nis) }}" class="result-card">
            <h4>{{ $s->nama }}</h4>
            <p>NIS: {{ $s->nis }}</p>
            <p>Angkatan: {{ $s->angkatan }}</p>
          </a>
        @endforeach
      </div>
    </div>
  @endisset

  <!-- DETAIL SANTRI -->
  @isset($santri)
  <a href="{{ route('landing') }}" class="back-button">
  ← Kembali
</a>


    <div class="student-details">

      <div class="profile-card">
        <h2>{{ $santri->nama }}</h2>
        <div class="profile-details">
          <span>NIS: {{ $santri->nis }}</span>
          <span>Angkatan: {{ $santri->angkatan }}</span>
        </div>
      </div>

      <div class="summary-grid">
        <div class="summary-card">
          <div class="summary-value">{{ $latestJuz ?? '-' }}</div>
          <p>Juz Terbaru</p>
        </div>

        <div class="summary-card">
          <div class="summary-value">{{ $bulanIni ?? 0 }}</div>
          <p>Setoran Bulan Ini (Halaman)</p>
        </div>

        <div class="summary-card">
          <div class="summary-value">{{ $bedaPersen }}%</div>
          <p>Perkembangan dari Bulan Lalu</p>
        </div>
      </div>

      <div class="timeline">
        @foreach($timeline as $t)
          <div class="timeline-item">
            <h4>{{ $t->tanggal_setoran->format('d M Y') }}</h4>
            <p>Juz {{ $t->juz }} — Halaman {{ $t->halaman }}</p>
            <i>{{ $t->catatan }}</i>
          </div>
        @endforeach
      </div>

    </div>
  @endisset

 @isset($chartLabels)
<h4 class="section-title">Perbandingan Setoran Beberapa Bulan Terakhir</h4>

<div class="chart-container">
    <canvas id="progressChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('progressChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Total Halaman',
                data: @json($chartValues),
                borderWidth: 1,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>
@endisset


<style>
.chart-container {
    width: 100%;
    height: 320px;
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    margin-top: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
}
.section-title {
    font-weight: 700;
    font-size: 20px;
    margin-top: 30px;
    margin-bottom: 12px;
}

.back-button {
    display: inline-block;
    margin-bottom: 20px;
    color: #3CA27B;
    font-weight: 600;
    text-decoration: none;
    font-size: 1rem;
}

.back-button:hover {
    text-decoration: underline;
}

</style>


</div>

</body>
</html>
