@extends('layouts.app')

@section('page_title', 'Nilai Mata Pelajaran')

{{-- Bootstrap & Font Awesome --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    :root {
        --primary-color: #28a745;
        --secondary-color: #ffc107;
        --delete-color: #dc3545;
        --border-color: #dee2e6;
        --text-color: #212529;
        --bg-light: #f8f9fa;
    }

    body {
        background-color: #e8f5e9;
    }

    .container-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px 15px;
    }

    .page-header {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px 25px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-header h4 {
        margin: 0;
        color: var(--primary-color);
        font-weight: 600;
    }

    .back-btn,
    .assign-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        padding: 8px 16px;
        border: 1px solid var(--primary-color);
        border-radius: 5px;
        background: white;
    }

    .back-btn:hover,
    .assign-btn:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .assign-btn {
        background-color: var(--primary-color);
        color: white;
    }

    .assign-btn:hover {
        background-color: #1e7e34;
    }

    .mapel-info-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e7e34 100%);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 20px;
        color: white;
    }

    .mapel-info-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .mapel-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .mapel-details h5 {
        margin: 0 0 5px 0;
        font-weight: 600;
        font-size: 22px;
        line-height: 1.2;
    }

    .mapel-details p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .mapel-stats {
        display: flex;
        gap: 30px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stat-item i {
        font-size: 20px;
        opacity: 0.9;
    }

    .stat-item div {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        opacity: 0.8;
    }

    .stat-value {
        font-size: 18px;
        font-weight: 600;
    }

    .nilai-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .nilai-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background-color: var(--bg-light);
        border-bottom: 1px solid var(--border-color);
    }

    .nilai-header h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .periode-selector {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .periode-selector label {
        margin: 0;
        font-weight: 500;
        white-space: nowrap;
    }

    .periode-selector select {
        padding: 6px 12px;
        border-radius: 5px;
        border: 1px solid var(--border-color);
        font-size: 14px;
        min-width: 100px;
        width: auto;
    }

    .save-btn-wrapper {
        padding: 15px 25px;
        display: flex;
        justify-content: flex-end;
        border-top: 1px solid var(--border-color);
        background-color: var(--bg-light);
    }

    .save-btn {
        background-color: var(--primary-color);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .save-btn:hover {
        background-color: #1e7e34;
        transform: translateY(-1px);
    }

    /* Table Styling */
    .table-responsive {
        max-height: 70vh;
        overflow-y: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1e7e34 100%);
        color: white !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 15px;
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    tbody td {
        padding: 12px 10px;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
    }

    tbody tr:hover {
        background-color: #eef6ff;
        transition: .2s;
    }

    .nilai-input {
        width: 80px;
        padding: 8px;
        border: 2px solid var(--border-color);
        border-radius: 5px;
        text-align: center;
        font-weight: 500;
    }

    .nilai-input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
    }

    .rata-input {
        background-color: var(--bg-light);
        font-weight: 600;
        color: var(--primary-color);
    }

    .rata-placeholder {
        background-color: #e9ecef;
        color: #6c757d;
        font-style: italic;
    }

    /* Predikat Badges */
    .predikat {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .predikat-A {
        background-color: #d4edda;
        color: #155724;
    }

    .predikat-B {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .predikat-C {
        background-color: #fff3cd;
        color: #856404;
    }

    .predikat-D {
        background-color: #f8d7da;
        color: #721c24;
    }

    .action-btn {
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        color: #fff;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--delete-color);
    }

    .action-btn:hover {
        opacity: 0.85;
        transform: scale(1.05);
    }

    .periode-section {
        display: none;
    }

    .periode-section.active {
        display: table-row-group;
    }

    /* Absensi compact */
    .absensi-group {
        display: flex;
        gap: 4px;
        justify-content: center;
    }

    .absensi-label {
        font-size: 10px;
        color: #666;
        text-align: center;
    }

    /* Total Absensi Badge */
    .total-absensi-badge {
        display: inline-block;
        background-color: #e9ecef;
        color: #495057;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 11px;
        margin-top: 2px;
    }

    .nilai-akhir-box {
        background-color: #f8f9fa;
        padding: 3px 8px;
        border-radius: 4px;
        font-weight: 600;
        color: var(--primary-color);
    }

    @media (max-width: 768px) {
        body {
            background-color: #f5f5f5;
        }

        .container-wrapper {
            padding: 0 0 20px 0;
        }

        .nilai-input {
            width: 60px;
            font-size: 12px;
            padding: 4px;
        }

        .absensi-group {
            gap: 2px;
        }
    }
</style>

@section('content')

    <div class="container-wrapper">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left">
                <h4>
                    <i class="fas fa-graduation-cap"></i> Nilai Mata Pelajaran
                </h4>
            </div>
            <div>
                <a href="{{ route('nilaiakademik.mapel.assign.form', $mapel->id_matapelajaran) }}" class="assign-btn">
                    <i class="fas fa-user-plus"></i> Assign Santri
                </a>
                <a href="{{ route('nilaiakademik.mapel.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Mapel Info Card -->
        <div class="mapel-info-card">
            <div class="mapel-info-header">
                <div class="mapel-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="mapel-details">
                    <h5>{{ $mapel->nama_matapelajaran }}</h5>
                    <p><i class="fas fa-calendar-alt me-2"></i>Tahun Ajaran: {{ $mapel->tahunAjaran->tahun }} - Semester
                        {{ strtoupper($mapel->tahunAjaran->semester) }}</p>
                </div>
            </div>
            <div class="mapel-stats">
                <div class="stat-item">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <div>
                        <span class="stat-label">Pendidik</span>
                        <span class="stat-value">{{ $mapel->pendidik->nama ?? '-' }}</span>
                    </div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-users"></i>
                    <div>
                        <span class="stat-label">Total Santri</span>
                        <span class="stat-value">{{ $nilai->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nilai Card -->
        <div class="nilai-card">
            <div class="nilai-header">
                <h5><i class="fas fa-clipboard-list"></i>Daftar Nilai</h5>
                <div class="periode-selector">
                    <label for="periodeSelect">Periode:</label>
                    <select id="periodeSelect" class="form-select">
                        <option value="uts">UTS</option>
                        <option value="uas">UAS</option>
                    </select>
                </div>
            </div>

            <form action="{{ route('nilaiakademik.mapel.updateAll', $mapel->id_matapelajaran) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_tahunAjaran" value="{{ $mapel->id_tahunAjaran }}">
                <input type="hidden" name="periode" id="periodeHidden" value="uts">

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Santri</th>
                                <th>Nilai</th>
                                <th>Ketidakhadiran</th>
                                <th>Nilai Akhir*</th>
                                <th>Predikat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <!-- === UTS SECTION === -->
                        <tbody id="section-uts" class="periode-section active">
                            <tr>
                                <th colspan="7" class="bg-light text-primary text-start">
                                    📌 Periode UTS — Nilai yang ditampilkan di rapor: <strong>Nilai UTS</strong>
                                </th>
                            </tr>
                            @foreach ($nilai as $n)
                                <tr data-id="{{ $n->id_nilai_akademik }}" data-uts="{{ $n->nilai_UTS ?? 0 }}"
                                    data-uas="{{ $n->nilai_UAS ?? 0 }}" data-praktik="{{ $n->nilai_praktik ?? 0 }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $n->santri->nama }}</td>

                                    <td>
                                        <!-- Hanya input UTS -->
                                        <input type="number" name="nilai[{{ $n->id_nilai_akademik }}][nilai_UTS]"
                                            value="{{ old('nilai.' . $n->id_nilai_akademik . '.nilai_UTS', $n->nilai_UTS) }}"
                                            class="nilai-input nilai-uts" placeholder="UTS"
                                            onchange="updatePreview(this, 'uts')">
                                    </td>

                                    <td>
                                        <div class="absensi-group">
                                            <div>
                                                <input type="number" name="nilai[{{ $n->id_nilai_akademik }}][izin_uts]"
                                                    value="{{ old('nilai.' . $n->id_nilai_akademik . '.izin_uts', $n->izin_uts) }}"
                                                    class="nilai-input" style="width:50px;" min="0">
                                                <div class="absensi-label">Izin</div>
                                            </div>
                                            <div>
                                                <input type="number" name="nilai[{{ $n->id_nilai_akademik }}][sakit_uts]"
                                                    value="{{ old('nilai.' . $n->id_nilai_akademik . '.sakit_uts', $n->sakit_uts) }}"
                                                    class="nilai-input" style="width:50px;" min="0">
                                                <div class="absensi-label">Sakit</div>
                                            </div>
                                            <div>
                                                <input type="number" name="nilai[{{ $n->id_nilai_akademik }}][ghaib_uts]"
                                                    value="{{ old('nilai.' . $n->id_nilai_akademik . '.ghaib_uts', $n->ghaib_uts) }}"
                                                    class="nilai-input" style="width:50px;" min="0">
                                                <div class="absensi-label">Ghaib</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <!-- Nilai akhir: hanya UTS untuk periode UTS -->
                                        <div class="nilai-akhir-box">
                                            {{ $n->nilai_UTS ?? '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            // Hitung predikat berdasarkan nilai UTS
                                            $nilaiUts = $n->nilai_UTS ?? 0;
                                            $predikatUts = $nilaiUts >= 85 ? 'A' :
                                                          ($nilaiUts >= 70 ? 'B' :
                                                          ($nilaiUts >= 55 ? 'C' : 'D'));
                                        @endphp
                                        <span class="predikat predikat-{{ $predikatUts }}">
                                            {{ $predikatUts }}
                                        </span>
                                    </td>

                                    <td>
                                        <button type="button" class="action-btn"
                                            onclick="deleteNilai('{{ $n->id_nilai_akademik }}')" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="white" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2">
                                                <path
                                                    d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <!-- === UAS SECTION === -->
                        <tbody id="section-uas" class="periode-section">
                            <tr>
                                <th colspan="7" class="bg-light text-success text-start">
                                    📌 Periode UAS — Nilai akhir rapor: <strong>Rata-rata (UTS + UAS + Praktik)</strong>
                                </th>
                            </tr>
                            @foreach ($nilai as $n)
                                <tr data-id="{{ $n->id_nilai_akademik }}" data-uts="{{ $n->nilai_UTS ?? 0 }}"
                                    data-uas="{{ $n->nilai_UAS ?? 0 }}" data-praktik="{{ $n->nilai_praktik ?? 0 }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $n->santri->nama }}</td>

                                    <td>
                                        <!-- Nilai UAS & Praktik sejajar -->
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            <div class="text-center">
                                                <input type="number"
                                                    name="nilai[{{ $n->id_nilai_akademik }}][nilai_UAS]"
                                                    value="{{ old('nilai.' . $n->id_nilai_akademik . '.nilai_UAS', $n->nilai_UAS) }}"
                                                    class="nilai-input nilai-uas" placeholder="UAS" style="width: 70px;"
                                                    onchange="updatePreview(this, 'uas')">
                                                <div class="absensi-label small mt-1">UAS</div>
                                            </div>
                                            <div class="text-center">
                                                <input type="number"
                                                    name="nilai[{{ $n->id_nilai_akademik }}][nilai_praktik]"
                                                    value="{{ old('nilai.' . $n->id_nilai_akademik . '.nilai_praktik', $n->nilai_praktik) }}"
                                                    class="nilai-input nilai-praktik" placeholder="Praktik"
                                                    style="width: 70px;" onchange="updatePreview(this, 'uas')">
                                                <div class="absensi-label small mt-1">Praktik</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="absensi-group">
                                            <div>
                                                <input type="number" name="nilai[{{ $n->id_nilai_akademik }}][izin_uas]"
                                                    value="{{ old('nilai.' . $n->id_nilai_akademik . '.izin_uas', $n->izin_uas) }}"
                                                    class="nilai-input" style="width:50px;" min="0">
                                                <div class="absensi-label">Izin</div>
                                            </div>
                                            <div>
                                                <input type="number"
                                                    name="nilai[{{ $n->id_nilai_akademik }}][sakit_uas]"
                                                    value="{{ old('nilai.' . $n->id_nilai_akademik . '.sakit_uas', $n->sakit_uas) }}"
                                                    class="nilai-input" style="width:50px;" min="0">
                                                <div class="absensi-label">Sakit</div>
                                            </div>
                                            <div>
                                                <input type="number"
                                                    name="nilai[{{ $n->id_nilai_akademik }}][ghaib_uas]"
                                                    value="{{ old('nilai.' . $n->id_nilai_akademik . '.ghaib_uas', $n->ghaib_uas) }}"
                                                    class="nilai-input" style="width:50px;" min="0">
                                                <div class="absensi-label">Ghaib</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <!-- Nilai akhir: rata-rata dari database -->
                                        <div class="nilai-akhir-box">
                                            {{ $n->nilai_rata_rata ?? '-' }}
                                        </div>
                                        @if($n->keterangan)
                                            <div class="small text-muted mt-1">
                                                {{ $n->keterangan }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="predikat predikat-{{ $n->predikat ?? 'D' }}">
                                            {{ $n->predikat ?? 'D' }}
                                        </span>
                                    </td>

                                    <td>
                                        <button type="button" class="action-btn"
                                            onclick="deleteNilai('{{ $n->id_nilai_akademik }}')" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="white" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2">
                                                <path
                                                    d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="save-btn-wrapper">
                    <button type="submit" class="save-btn">
                        <i class="fas fa-save"></i> Simpan Data Periode <span id="periodeLabel">UTS</span>
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- DELETE FORM -->
    <form id="deleteForm" method="POST" style="display:none;">
        @csrf @method('DELETE')
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const periodeSelect = document.getElementById('periodeSelect');
            const periodeHidden = document.getElementById('periodeHidden');
            const periodeLabel = document.getElementById('periodeLabel');
            const sectionUTS = document.getElementById('section-uts');
            const sectionUAS = document.getElementById('section-uas');

            function toggleSection(periode) {
                if (periode === 'uts') {
                    sectionUTS.classList.add('active');
                    sectionUAS.classList.remove('active');
                    periodeLabel.textContent = 'UTS';
                } else {
                    sectionUTS.classList.remove('active');
                    sectionUAS.classList.add('active');
                    periodeLabel.textContent = 'UAS';
                }
                periodeHidden.value = periode;
            }

            periodeSelect.value = '{{ request('periode', 'uts') }}';
            toggleSection(periodeSelect.value);

            periodeSelect.addEventListener('change', function() {
                toggleSection(this.value);
            });

            window.updatePreview = function(input, periode) {
                const row = input.closest('tr');
                const id = row.dataset.id;

                // Ambil nilai terbaru dari input + fallback ke data awal
                const uts = parseFloat(row.querySelector('input[name$="[nilai_UTS]"]')?.value) || parseFloat(row
                    .dataset.uts) || 0;
                const uas = parseFloat(row.querySelector('input[name$="[nilai_UAS]"]')?.value) || parseFloat(row
                    .dataset.uas) || 0;
                const praktik = parseFloat(row.querySelector('input[name$="[nilai_praktik]"]')?.value) ||
                    parseFloat(row.dataset.praktik) || 0;

                const nilaiAkhirEl = row.querySelector('.nilai-akhir-box');
                const predEl = row.querySelector('.predikat');

                if (periode === 'uts') {
                    // Preview UTS: tampilkan nilai UTS saja
                    nilaiAkhirEl.textContent = uts > 0 ? uts.toFixed(0) : '-';
                    const pred = getPredikat(uts);
                    predEl.textContent = pred;
                    predEl.className = 'predikat predikat-' + pred;

                } else if (periode === 'uas') {
                    // Preview UAS: hitung dengan bobot (30% UTS, 40% UAS, 30% Praktik)
                    const rata = calculateWeightedAverage(uts, uas, praktik);
                    nilaiAkhirEl.textContent = rata > 0 ? rata.toFixed(2) : '-';
                    const pred = getPredikat(rata);
                    predEl.textContent = pred;
                    predEl.className = 'predikat predikat-' + pred;
                }
            };

            function calculateWeightedAverage(uts, uas, praktik) {
                // Bobot: 30% UTS, 40% UAS, 30% Praktik
                const weightedAverage = (uts * 0.3) + (uas * 0.4) + (praktik * 0.3);
                return parseFloat(weightedAverage.toFixed(2));
            }

            function getPredikat(nilai) {
                if (nilai >= 90) return 'A';
                if (nilai >= 80) return 'B';
                if (nilai >= 70) return 'C';
                if (nilai >= 60) return 'D';
                return 'E';
            }

            window.deleteNilai = function(id) {
                if (confirm('Hapus data nilai ini?')) {
                    const form = document.getElementById('deleteForm');
                    form.action = "{{ route('nilaiakademik.mapel.destroy', ':id') }}".replace(':id', id);
                    form.submit();
                }
            };
        });
    </script>
@endsection
