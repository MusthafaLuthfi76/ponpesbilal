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
  transition: all 0.3s;
}

.search-input:focus {
  outline: none;
  border-color: #3CA27B;
  box-shadow: 0 0 0 3px rgba(60, 162, 123, 0.1);
}

.search-button {
  background: #3CA27B;
  color: white;
  padding: 1.2rem 2rem;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.3s;
}

.search-button:hover {
  background: #318b69;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(60, 162, 123, 0.3);
}

/* Search Results */
.search-results {
  margin-top: 3rem;
}

.search-results-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
  gap: 1rem;
}

.search-results h3 {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0;
}

.per-page-selector {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.per-page-selector label {
  font-size: 0.9rem;
  color: #666;
  font-weight: 500;
}

.per-page-selector select {
  padding: 0.5rem 1rem;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.3s;
}

.per-page-selector select:focus {
  outline: none;
  border-color: #3CA27B;
}

.results-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

/* Result Card with Avatar */
.result-card {
  background: white;
  border: 2px solid #e0e0e0;
  padding: 1.5rem;
  border-radius: 12px;
  text-decoration: none;
  color: #1a1a1a;
  transition: all 0.3s ease;
  cursor: pointer;
  display: block;
}

.result-card:hover {
  border-color: #3CA27B;
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(60, 162, 123, 0.15);
}

.result-card-content {
  display: flex;
  align-items: center;
  gap: 1.5rem;
}

.result-avatar {
  width: 60px;
  height: 60px;
  min-width: 60px;
  background: linear-gradient(135deg, #3CA27B, #2d8a64);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}

.avatar-icon {
  width: 32px;
  height: 32px;
  color: white;
}

.result-card:hover .result-avatar {
  transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(60, 162, 123, 0.3);
}

.result-info {
  flex: 1;
  text-align: left;
}

.result-info h4 {
  margin: 0 0 0.5rem 0;
  font-size: 1.1rem;
  font-weight: 600;
  color: #1a1a1a;
}

.result-info p {
  margin: 0.25rem 0;
  color: #666;
  font-size: 0.9rem;
}

.result-info p strong {
  color: #3CA27B;
}

/* Pagination */
.pagination-wrapper {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
}

.pagination {
  display: flex;
  gap: 0.5rem;
  list-style: none;
  padding: 0;
  margin: 0;
}

.pagination li {
  display: inline-block;
}

.pagination a,
.pagination span {
  display: block;
  padding: 0.75rem 1rem;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  color: #666;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s;
}

.pagination a:hover {
  border-color: #3CA27B;
  color: #3CA27B;
  background: rgba(60, 162, 123, 0.05);
}

.pagination .active span {
  background: #3CA27B;
  color: white;
  border-color: #3CA27B;
}

.pagination .disabled span {
  opacity: 0.5;
  cursor: not-allowed;
}

.no-results {
  text-align: center;
  padding: 3rem 2rem;
  background: white;
  border-radius: 12px;
  border: 2px solid #e0e0e0;
}

.no-results p {
  color: #666;
  font-size: 1.1rem;
}

/* Student Detail */
.student-details {
  max-width: 1000px;
  margin: 0 auto;
}

/* New Search Button */
.new-search-button {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 2rem;
  padding: 0.9rem 1.8rem;
  background: white;
  color: #3CA27B;
  border: 2px solid #3CA27B;
  border-radius: 12px;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s;
}

.new-search-button:hover {
  background: #3CA27B;
  color: white;
  transform: translateX(-3px);
}

/* Profile Card */
.profile-card {
  background: #fff;
  padding: 2.5rem;
  border-radius: 16px;
  border: 2px solid #e0e0e0;
  margin-bottom: 3rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.profile-content {
  display: flex;
  align-items: center;
  gap: 2rem;
}

.profile-photo {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: linear-gradient(135deg, #3CA27B, #2d8a64);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  flex-shrink: 0;
  border: 4px solid #3CA27B;
}

.profile-photo svg {
  width: 60px;
  height: 60px;
}

.profile-info h2 {
  margin: 0 0 1rem 0;
  font-size: 2rem;
  font-weight: 700;
  color: #1a1a1a;
}

.profile-details {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.profile-details span {
  font-size: 1rem;
  color: #666;
}

/* Summary Cards */
.summary-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
  margin-bottom: 3rem;
}

.summary-card {
  background: #fff;
  padding: 0;
  border-radius: 16px;
  border: 2px solid #e0e0e0;
  transition: all 0.3s;
  overflow: hidden;
}

.summary-card:hover {
  border-color: #3CA27B;
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(60, 162, 123, 0.15);
}

.summary-card-header {
  padding: 1.5rem 1.5rem 0.5rem;
}

.summary-icon {
  width: 40px;
  height: 40px;
  color: #3CA27B;
  margin-bottom: 0.5rem;
}

.summary-card-title {
  font-size: 1rem;
  font-weight: 600;
  color: #4a4a4a;
  margin: 0;
}

.summary-card-body {
  padding: 0.5rem 1.5rem 1.5rem;
}

.summary-value {
  font-size: 2.5rem;
  font-weight: 800;
  color: #1a1a1a;
  margin-bottom: 0.5rem;
}

.summary-value.positive {
  color: #3CA27B;
}

.summary-value.negative {
  color: #e74c3c;
}

.summary-subtitle {
  font-size: 0.9rem;
  color: #666;
  margin: 0.5rem 0 0;
}

.progress-bar-container {
  margin-top: 1rem;
  margin-bottom: 0.5rem;
}

.progress-bar {
  width: 100%;
  height: 8px;
  background: #e0e0e0;
  border-radius: 10px;
  overflow: hidden;
}

.progress-bar-fill {
  height: 100%;
  background: linear-gradient(90deg, #3CA27B, #5fcc9a);
  border-radius: 10px;
  transition: width 0.6s ease;
}

.progress-text {
  font-size: 0.85rem;
  color: #666;
  text-align: center;
}

/* Chart Card */
.chart-card {
  background: white;
  border: 2px solid #e0e0e0;
  border-radius: 16px;
  margin-bottom: 3rem;
  overflow: hidden;
}

.chart-card-header {
  padding: 1.5rem;
  border-bottom: 2px solid #f0f0f0;
}

.chart-card-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0 0 0.5rem 0;
}

.chart-card-subtitle {
  font-size: 0.9rem;
  color: #666;
  margin: 0;
}

.chart-card-body {
  padding: 2rem 1rem;
}

.chart-bars {
  display: flex;
  justify-content: space-around;
  align-items: flex-end;
  height: 300px;
  gap: 2rem;
}

.chart-bar-item {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

.chart-bar-wrapper {
  width: 100%;
  height: 250px;
  display: flex;
  align-items: flex-end;
  justify-content: center;
}

.chart-bar {
  width: 80px;
  background: linear-gradient(to top, #3CA27B, #5fcc9a);
  border-radius: 8px 8px 0 0;
  position: relative;
  min-height: 6px;
  display: flex;
  align-items: flex-end;
  justify-content: center;
  padding-bottom: 0.5rem;
  transition: all 0.3s;
}

.chart-bar:hover {
  transform: scaleY(1.05);
  box-shadow: 0 4px 12px rgba(60, 162, 123, 0.3);
}

.chart-value {
  color: white;
  font-weight: 700;
  font-size: 0.9rem;
}

.chart-label {
  font-size: 0.9rem;
  font-weight: 600;
  color: #4a4a4a;
  text-align: center;
}

/* Garis Threshold */
.chart-threshold-line {
  position: absolute;
  left: 0;
  width: 100%;
  height: 2px;
  background: #FF5722;
  opacity: 0.8;
  z-index: 5;
}

.threshold-label {
  position: absolute;
  right: 0;
  top: -20px;
  background: #FF5722;
  padding: 3px 8px;
  border-radius: 4px;
  font-size: 0.75rem;
  color: white;
  font-weight: bold;
}

/* Pastikan chart body bisa menampung threshold absolute */
.chart-card-body {
  position: relative;
  padding-top: 3rem;
}


/* Timeline Card */
.timeline-card {
  background: white;
  border: 2px solid #e0e0e0;
  border-radius: 16px;
  overflow: hidden;
}

.timeline-card-header {
  padding: 1.5rem;
  border-bottom: 2px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
}

.timeline-card-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0;
}

.timeline-card-body {
  padding: 1.5rem;
}

.timeline {
  padding: 1rem 0;
}

.timeline-item {
  display: flex;
  gap: 1.5rem;
  padding: 1.5rem 0;
  position: relative;
}

.timeline-item:not(:last-child)::before {
  content: '';
  position: absolute;
  left: 11px;
  top: 40px;
  bottom: -20px;
  width: 2px;
  background: #e0e0e0;
}

.timeline-marker {
  width: 24px;
  height: 24px;
  background: #3CA27B;
  border-radius: 50%;
  border: 4px solid #e8f5f0;
  flex-shrink: 0;
  position: relative;
  z-index: 1;
}

.timeline-content {
  flex: 1;
  padding-bottom: 1rem;
}

.timeline-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.5rem;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.timeline-date {
  font-size: 0.9rem;
  color: #666;
}

.timeline-juz {
  font-weight: 700;
  color: #3CA27B;
  font-size: 1rem;
}

.timeline-pages {
  font-size: 0.9rem;
  color: #666;
  margin-top: 0.5rem;
  padding: 0.5rem;
  background: #f8f9fa;
  border-radius: 6px;
  display: inline-block;
}

.timeline-pages strong {
  color: #3CA27B;
}

.timeline-note {
  font-size: 0.9rem;
  color: #4a4a4a;
  font-style: italic;
  margin: 0.5rem 0 0;
  padding: 0.75rem;
  background: #f8f9fa;
  border-radius: 8px;
  border-left: 3px solid #3CA27B;
}

/* Back Button */
.top-back-wrapper {
  margin-bottom: 2rem;
}

.back-button {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: #3CA27B;
  font-weight: 600;
  text-decoration: none;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.back-button:hover {
  color: #318b69;
  gap: 0.7rem;
}

/* Responsive */
@media (max-width: 768px) {
  .search-input-group {
    flex-direction: column;
  }
  
  .results-grid {
    grid-template-columns: 1fr;
  }
  
  .profile-content {
    flex-direction: column;
    text-align: center;
  }
  
  .profile-details {
    justify-content: center;
  }
  
  .summary-grid {
    grid-template-columns: 1fr;
  }

  .chart-bars {
    height: 250px;
    padding: 1rem 0.5rem;
    gap: 1rem;
  }

  .chart-bar-wrapper {
    height: 200px;
  }

  .chart-bar {
    width: 60px;
  }

  .timeline-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .result-card-content {
    gap: 1rem;
  }

  .result-avatar {
    width: 50px;
    height: 50px;
    min-width: 50px;
  }

  .avatar-icon {
    width: 26px;
    height: 26px;
  }

  .search-results-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .timeline-card-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .chart-bars {
    gap: 1rem;
  }

  .chart-bar {
    width: 40px;
  }

  .chart-value {
    font-size: 0.75rem;
  }

  .chart-label {
    font-size: 0.75rem;
  }

  .threshold-label {
    font-size: 0.65rem;
    padding: 2px 6px;
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

  @if(!isset($santri))
  <div class="top-back-wrapper">
    <a href="{{ route('landing') }}" class="back-button">
      <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
      Kembali
    </a>
  </div>
  @endif

  <!-- SEARCH BOX -->
  @if(!isset($santri))
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
        <input type="text" name="q" class="search-input" placeholder="Contoh: Ahmad / 2023011" 
               value="{{ $searchQuery ?? '' }}" required>
        <button type="submit" class="search-button">Cari</button>
      </div>
    </form>
  </div>
  @endif

  <!-- HASIL PENCARIAN -->
  @if(isset($results) && !isset($santri))
    <div class="search-results">
      @if($results->count() > 0)
        <div class="search-results-header">
          <h3>Hasil Pencarian ({{ $results->total() }} santri ditemukan)</h3>
          
          <div class="per-page-selector">
            <label for="per-page">Tampilkan:</label>
            <select id="per-page" onchange="changePerPage(this.value)">
              <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 per halaman</option>
              <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 per halaman</option>
              <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 per halaman</option>
            </select>
          </div>
        </div>

        <div class="results-grid">
          @foreach($results as $s)
            <a href="{{ route('progress.show', $s->nis) }}" class="result-card">
              <div class="result-card-content">
                <div class="result-avatar">
                  <svg class="avatar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <div class="result-info">
                  <h4>{{ $s->nama }}</h4>
                  <p><strong>NIS:</strong> {{ $s->nis }}</p>
                  <p><strong>Angkatan:</strong> {{ $s->angkatan }}</p>
                </div>
              </div>
            </a>
          @endforeach
        </div>

        <div class="pagination-wrapper">
          {{ $results->links() }}
        </div>
      @else
        <div class="no-results">
          <p>Tidak ada data santri yang ditemukan dengan kata kunci "<strong>{{ $searchQuery }}</strong>"</p>
          <p style="margin-top: 1rem; color: #999;">Silakan coba dengan nama atau NIS yang lain</p>
        </div>
      @endif
    </div>
  @endif

  <!-- DETAIL SANTRI -->
  @if(isset($santri))
    <div class="student-details">
      <a href="{{ route('progress.index') }}" class="new-search-button">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
        </svg>
        Cari Santri Lain
      </a>

      <!-- PROFILE CARD -->
      <div class="profile-card">
        <div class="profile-content">
          <div class="profile-photo">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
          <div class="profile-info">
            <h2>{{ $santri->nama }}</h2>
            <div class="profile-details">
              <span><strong>NIS:</strong> {{ $santri->nis }}</span>
              <span>•</span>
              <span><strong>Angkatan:</strong> {{ $santri->angkatan }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- SUMMARY CARDS -->
      <div class="summary-grid">
        <!-- Total Hafalan -->
        <div class="summary-card">
          <div class="summary-card-header">
            <svg class="summary-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
            <h3 class="summary-card-title">Total Hafalan</h3>
          </div>
          <div class="summary-card-body">
            <div class="summary-value">{{ $latestJuz ?? '-' }} Juz</div>
            <p class="summary-subtitle">Terakhir Setoran: Juz {{ $latestJuz ?? '-' }}</p>
            <div class="progress-bar-container">
              <div class="progress-bar">
                <div class="progress-bar-fill" style="width: {{ ($latestJuz ?? 0) / 30 * 100 }}%"></div>
              </div>
            </div>
            <p class="progress-text">{{ number_format(($latestJuz ?? 0) / 30 * 100, 1) }}% dari 30 Juz</p>
          </div>
        </div>

        <!-- Setoran Bulan Ini -->
        <div class="summary-card">
          <div class="summary-card-header">
            <svg class="summary-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="summary-card-title">Setoran Bulan Ini</h3>
          </div>
          <div class="summary-card-body">
            <div class="summary-value">{{ $bulanIni ?? 0 }}</div>
            <p class="summary-subtitle">Halaman</p>
          </div>
        </div>

        <!-- Perbandingan -->
        <div class="summary-card">
          <div class="summary-card-header">
            <svg class="summary-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-li
              nejoin="round" stroke-width="2"
                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            <h3 class="summary-card-title">Perbandingan Bulan Lalu</h3>
          </div>
          <div class="summary-card-body">
            <div class="summary-value {{ $bedaPersen >= 0 ? 'positive' : 'negative' }}">
              {{ $bedaPersen >= 0 ? '+' : '' }}{{ $bedaPersen }}%
            </div>
            <p class="summary-subtitle">Bulan lalu: {{ $bulanLalu ?? 0 }} halaman</p>
          </div>
        </div>
      </div>

      @php
          // Ambang batas threshold
          $threshold = 20;

          // Filter hanya 4 bulan terakhir
          $last4Indexes = array_slice(array_keys($chartLabels), -4);
          $chartLabels4 = array_intersect_key($chartLabels, array_flip($last4Indexes));
          $chartValues4 = array_intersect_key($chartValues, array_flip($last4Indexes));

          // Tinggi maksimal bar = threshold (untuk membandingkan ke ambang batas)
          $maxHeight = max(max($chartValues4), $threshold);
      @endphp

      @if(count($chartLabels4) > 0)
      <div class="chart-card">
          <div class="chart-card-header">
              <h3 class="chart-card-title">Progress 4 Bulan Terakhir</h3>
              <p class="chart-card-subtitle">Threshold: {{ $threshold }} halaman per bulan</p>
          </div>

          <div class="chart-card-body">
              
              <!-- Garis Threshold -->
              <div class="chart-threshold-line" 
                  style="bottom: {{ ($threshold / $maxHeight) * 100 }}%">
                  <span class="threshold-label">
                      Threshold ({{ $threshold }} halaman)
                  </span>
              </div>

              <div class="chart-bars">
                  @foreach($chartLabels4 as $index => $label)
                      <div class="chart-bar-item">
                          <div class="chart-bar-wrapper">
                              <div class="chart-bar"
                                  style="height: {{ ($chartValues4[$index] / $maxHeight) * 100 }}%">
                                  <span class="chart-value">{{ $chartValues4[$index] }}</span>
                              </div>
                          </div>
                          <p class="chart-label">{{ $label }}</p>
                      </div>
                  @endforeach
              </div>

          </div>
      </div>
      @endif

            <script>
              // Debug info for chart calculations (will appear in browser console)
              try {
                const _chartDebug = {
                  labels: @json(array_values($chartLabels4 ?? [])),
                  values: @json(array_values($chartValues4 ?? [])),
                  maxHeight: {{ $maxHeight ?? 0 }},
                  threshold: {{ $threshold ?? 0 }}
                };
                console.info('CHART DEBUG:', _chartDebug);
              } catch (e) {
                console.warn('Chart debug unavailable', e);
              }
            </script>

      <!-- TIMELINE -->
      <div class="timeline-card">
        <div class="timeline-card-header">
          <h3 class="timeline-card-title">Riwayat Setoran</h3>
          
          <div class="per-page-selector">
            <label for="timeline-per-page">Tampilkan:</label>
            <select id="timeline-per-page" onchange="changeTimelinePerPage(this.value)">
              <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 per halaman</option>
              <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 per halaman</option>
              <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 per halaman</option>
            </select>
          </div>
        </div>
        <div class="timeline-card-body">
          <div class="timeline">
            @foreach($timeline as $t)
              <div class="timeline-item">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                  <div class="timeline-header">
                    <span class="timeline-date">{{ $t->tanggal_setoran->format('d F Y') }}</span>
                    <span class="timeline-juz">Juz {{ $t->juz }}, Hal. {{ $t->halaman }}</span>
                  </div>
                  <div class="timeline-pages">
                    <strong>Halaman:</strong> {{ $t->halaman_awal }} - {{ $t->halaman_akhir }} 
                    ({{ $t->halaman_akhir - $t->halaman_awal + 1 }} halaman)
                  </div>
                  @if($t->catatan)
                    <p class="timeline-note">Catatan: {{ $t->catatan }}</p>
                  @endif
                </div>
              </div>
            @endforeach
          </div>

          @if($timeline->hasPages())
          <div class="pagination-wrapper">
            {{ $timeline->links() }}
          </div>
          @endif
        </div>
      </div>

    </div>
  @endif

</div>

<script>
  // Change per page for search results
  function changePerPage(perPage) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('per_page', perPage);
    window.location.search = urlParams.toString();
  }

  // Change per page for timeline
  function changeTimelinePerPage(perPage) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('per_page', perPage);
    window.location.search = urlParams.toString();
  }
</script>

</body>
</html>