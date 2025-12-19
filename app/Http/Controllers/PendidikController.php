<?php

namespace App\Http\Controllers;

use App\Models\Pendidik;
use App\Models\User;
use Illuminate\Http\Request;

class PendidikController extends Controller
{
    // 🔹 Menampilkan semua data pendidik
    public function index()
    {
         $pendidik = Pendidik::all();
        $users = User::select('id_user', 'nama')->get();
        return view('pendidik.index', compact('pendidik', 'users'));
    }
    // 🔹 Menyimpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required','string','max:100','regex:/^[A-Za-z\s]+$/'],
            'jabatan' => ['required','string','max:50','regex:/^[A-Za-z\s]+$/'],
            'id_user' => 'required|exists:user,id_user',
        ]);

        Pendidik::create($validated);

        return redirect()->route('pendidik.index')->with('success', 'Data pendidik berhasil ditambahkan!');
    }

    // 🔹 Menampilkan data berdasarkan ID
    public function show($id)
    {
        $pendidik = Pendidik::with('user')->findOrFail($id);
        return response()->json($pendidik);
    }

    // 🔹 Update data
    public function update(Request $request, $id)
    {
        $pendidik = Pendidik::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required','string','max:100','regex:/^[A-Za-z\s]+$/'],
            'jabatan' => ['required','string','max:50','regex:/^[A-Za-z\s]+$/'],
            'id_user' => 'required|exists:user,id_user',
        ]);

        $pendidik->update($validated);

        return redirect()->route('pendidik.index')->with('success', 'Data pendidik berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pendidik = Pendidik::findOrFail($id);
        $pendidik->delete();

        return redirect()->route('pendidik.index')->with('success', 'Data pendidik berhasil dihapus!');
    }
}
