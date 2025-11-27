<?php

namespace App\Http\Controllers;

use App\Models\NilaiKesantrian;
use App\Models\Santri;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Http\Controllers\Controller; // Pastikan ini ada jika menggunakan namespace Controller
use Illuminate\Http\Request;

class NilaiKesantrianController extends Controller
{
    /**
     * TAMPILKAN SEMUA MATA PELAJARAN KESANTRIAN (Index)
     */
    public function index(Request $request)
{
    // Ambil semua Tahun Ajaran untuk filter utama dan modal
    $tahunAjaran = TahunAjaran::orderBy('tahun', 'desc')->get();
    
    // --- Bagian yang sudah ada (untuk menampilkan list di bawah filter) ---
    $query = MataPelajaran::query();
    $query->where('nama_matapelajaran', 'LIKE', '%Kesantrian%'); 
    
    if ($request->filled('id_tahunAjaran')) {
        $query->where('id_tahunAjaran', $request->id_tahunAjaran);
    }
    $matapelajaranKesantrian = $query->with('tahunAjaran')->get();
    // --------------------------------------------------------------------

    // --- BARU: Ambil semua Mata Pelajaran bertipe Kesantrian (Template) untuk Modal ---
    // Di sini kita ambil semua mapel Kesantrian, tanpa filter Tahun Ajaran,
    // karena tujuannya hanya memilih template Mata Pelajaran Kesantrian.
    $mapelKesantrianList = MataPelajaran::where('nama_matapelajaran', 'LIKE', '%Kesantrian%')->get();

    // Kirim data baru ke view
    return view('nilaikesantrian.index', compact('matapelajaranKesantrian', 'tahunAjaran', 'mapelKesantrianList'));
}

    /**
     * SIMPAN MATA PELAJARAN KESANTRIAN BARU (Dari Modal di Index)
     */
   public function store(Request $request)
{
    $request->validate([
        'id_matapelajaran_template' => 'required|exists:matapelajaran,id_matapelajaran',
        'id_tahunAjaran' => 'required|exists:tahunajaran,id_tahunAjaran',
    ]);

    $templateMapel = MataPelajaran::findOrFail($request->id_matapelajaran_template);
    
    // --- KRUSIAL: LOGIKA CEK DUPLIKASI BARU ---
    $existing = MataPelajaran::where('nama_matapelajaran', $templateMapel->nama_matapelajaran)
        ->where('id_tahunAjaran', $request->id_tahunAjaran)
        ->first();

    if ($existing) {
        return back()->with('error', 'Mata Pelajaran Kesantrian dengan nama "' . $templateMapel->nama_matapelajaran . '" untuk Tahun Ajaran ini sudah dibuat.')->withInput();
    }
    // --- AKHIR LOGIKA CEK DUPLIKASI ---

    // ... (Logika penentuan $newId dan MataPelajaran::create) ...

    $newId = MataPelajaran::max('id_matapelajaran');
    $newId = $newId ? $newId + 1 : 1; 
    
    $newMapel = MataPelajaran::create([
        'id_matapelajaran' => $newId, 
        'nama_matapelajaran' => $templateMapel->nama_matapelajaran,
        'kkm' => $templateMapel->kkm,
        'bobot_UTS' => $templateMapel->bobot_UTS,
        'bobot_UAS' => $templateMapel->bobot_UAS,
        
        // <<< SOLUSI: TAMBAH KOLOM bobot_praktik >>>
        'bobot_praktik' => $templateMapel->bobot_praktik, // <--- Baris ini ditambahkan
        
        'id_pendidik' => $templateMapel->id_pendidik, 
        'id_tahunAjaran' => $request->id_tahunAjaran, 
    ]);
    
    return redirect()->route('nilaikesantrian.index', ['id_tahunAjaran' => $request->id_tahunAjaran])
        ->with('success', 'Mata Pelajaran Kesantrian untuk Tahun Ajaran berhasil ditambahkan. Silakan klik Detail untuk melakukan Assign Santri.');
}


    /**
     * TAMPILKAN DETAIL DAN DATA INPUT/ASSIGN (Show)
     */
    public function show($id_matapelajaran, $id_tahunAjaran, Request $request)
    {
        $mapel = MataPelajaran::findOrFail($id_matapelajaran); // <-- OK, ambil mapel yang baru dibuat
        $tahunAjaran = TahunAjaran::findOrFail($id_tahunAjaran); // <-- OK, ambil tahun ajaran

        // 1. Data Santri yang SUDAH memiliki record Nilai Kesantrian
        $nilaiSantri = NilaiKesantrian::with('santri')
            ->where('id_matapelajaran', $id_matapelajaran)
            ->where('id_tahunAjaran', $id_tahunAjaran)
            ->get();

        // 2. Data Santri yang BELUM memiliki record Nilai Kesantrian (untuk tab Assign)
        $querySantriBelum = Santri::query();
        
        // --- Terapkan Filter & Search dari Request di Tab Assign ---
        if ($request->filled('angkatan')) {
            $querySantriBelum->where('angkatan', $request->angkatan);
        }
        if ($request->filled('search_nama')) {
            $querySantriBelum->where('nama', 'LIKE', '%' . $request->search_nama . '%');
        }
        // ---------------------------------------------------------
        
        $querySantriBelum->whereDoesntHave('nilaiKesantrian', function ($q) use ($id_matapelajaran, $id_tahunAjaran) {
            $q->where('id_matapelajaran', $id_matapelajaran)
              ->where('id_tahunAjaran', $id_tahunAjaran);
        });

        $santriBelumAssign = $querySantriBelum->get();
        
        // Ambil daftar angkatan untuk filter
        $angkatanList = Santri::select('angkatan')->distinct()->pluck('angkatan');


        return view('nilaikesantrian.detail', compact(
            'mapel',
            'tahunAjaran',
            'nilaiSantri',
            'santriBelumAssign',
            'angkatanList'
        ));
    }


    /**
     * SIMPAN SANTRI KE MAPEL KESANTRIAN (Assign Store)
     */
    public function assignStore(Request $request, $id_matapelajaran, $id_tahunAjaran)
    {
        $request->validate(['nis' => 'required|array']);

        foreach ($request->nis as $nis) {
            NilaiKesantrian::firstOrCreate([
                'nis' => $nis,
                'id_matapelajaran' => $id_matapelajaran, 
                'id_tahunAjaran' => $id_tahunAjaran,
            ]);
        }

        return redirect()->route('nilaikesantrian.show', [
            'id_matapelajaran' => $id_matapelajaran, 
            'id_tahunAjaran' => $id_tahunAjaran,
            'tab' => 'assign'
        ])->with('success', 'Santri berhasil di-assign ke Mata Pelajaran Kesantrian ini.');
    }

    public function unassign($id)
    {
        $nilai = NilaiKesantrian::find($id);

        if (!$nilai) {
            return back()->with('error', 'Data Nilai Kesantrian tidak ditemukan.');
        }

        // Simpan data untuk redirect kembali
        $id_matapelajaran = $nilai->id_matapelajaran;
        $id_tahunAjaran = $nilai->id_tahunAjaran;

        $nilai->delete();

        return redirect()->route('nilaikesantrian.show', [
            'id_matapelajaran' => $id_matapelajaran,
            'id_tahunAjaran' => $id_tahunAjaran,
        ])->with('success', 'Santri berhasil di-unassign dari mata pelajaran ini.');
    }

    /**
     * UPDATE NILAI KESANTRIAN SECARA MASSAL (Update Massal)
     */
    public function updateNilaiMassal(Request $request)
    {
        $data = $request->input('nilai', []);

        if(empty($data)) {
            return redirect()->back()->with('error', 'Tidak ada data nilai yang dikirim.');
        }

        foreach ($data as $id_nilai => $fields) {
            $nilai = NilaiKesantrian::find($id_nilai);
            if ($nilai) {
                $nilai->update([
                    'nilai_akhlak' => $fields['nilai_akhlak'] ?? '',
                    'nilai_ibadah' => $fields['nilai_ibadah'] ?? '',
                    'nilai_kerapian' => $fields['nilai_kerapian'] ?? '',
                    'nilai_kedisiplinan' => $fields['nilai_kedisiplinan'] ?? '',
                    'nilai_ekstrakulikuler' => $fields['nilai_ekstrakulikuler'] ?? '',
                    'nilai_buku_pegangan' => $fields['nilai_buku_pegangan'] ?? '',
                ]);
            }
        }
        
        // Redirect dengan membawa ID mapel dan TA agar tetap di halaman yang sama
        $id_matapelajaran = $request->input('id_matapelajaran');
        $id_tahunAjaran = $request->input('id_tahunAjaran');

        return redirect()->route('nilaikesantrian.show', [
            'id_matapelajaran' => $id_matapelajaran,
            'id_tahunAjaran' => $id_tahunAjaran,
        ])->with('success', 'Semua nilai berhasil diperbarui!');
    }
    
    // --- FUNGSI STANDAR CRUD INDIVIDUAL (Jika masih diperlukan) ---

    /**
     * FORM EDIT NILAI
     */
    public function edit($id)
    {
        $nilai = NilaiKesantrian::findOrFail($id);
        $santri = Santri::all();
        $mapel = MataPelajaran::all(); 
        $tahunAjaran = TahunAjaran::all();
        return view('nilaikesantrian.edit', compact('nilai', 'santri', 'mapel', 'tahunAjaran'));
    }

    /**
     * UPDATE NILAI INDIVIDUAL
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|exists:santri,nis',
            'id_matapelajaran' => 'required|exists:matapelajaran,id_matapelajaran',
            'id_tahunAjaran' => 'required|exists:tahunajaran,id_tahunAjaran',
            'nilai_akhlak' => 'nullable|string|max:10',
            // ... (validasi kolom nilai lainnya)
        ]);

        $nilai = NilaiKesantrian::findOrFail($id);

        $exists = NilaiKesantrian::where('id_nilai_kesantrian', '!=', $id)
            ->where([
                'nis' => $request->nis,
                'id_matapelajaran' => $request->id_matapelajaran,
                'id_tahunAjaran' => $request->id_tahunAjaran,
            ])->exists();

        if ($exists) {
            return back()->withErrors(['duplicate' => 'Nilai untuk kombinasi ini sudah ada.']);
        }

        $nilai->update($request->all());

        return redirect()->route('nilaikesantrian.index')
            ->with('success', 'Nilai kesantrian berhasil diperbarui.');
    }

    /**
     * HAPUS NILAI
     */
    public function destroy($id)
    {
        $nilai = NilaiKesantrian::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilaikesantrian.index')
            ->with('success', 'Nilai kesantrian berhasil dihapus.');
    }
    
    // FUNGSI LAMA SEPERTI create(), indexTahunAjaran(), assign(), updateAll(), showByTahun() DIHAPUS UNTUK KONSISTENSI
}