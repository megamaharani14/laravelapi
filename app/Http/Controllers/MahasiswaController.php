<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index()
    {
        return Mahasiswa::all();  // Mengambil semua data mahasiswa
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'jurusan' => 'required',
        ]);

        return Mahasiswa::create($request->all());  // Menyimpan data baru
    }

    public function show($id)
    {
        return Mahasiswa::findOrFail($id);  // Mengambil data berdasarkan ID
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());  // Mengupdate data
        return $mahasiswa;
    }

    public function destroy($id)
    {
        // Cek apakah pengguna memiliki peran admin
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat menghapus data.'
            ], 403);
        }

        // Menghapus data mahasiswa
        Mahasiswa::destroy($id);  
        return response()->json(['message' => 'Data berhasil dihapus']);


        //Mengupdate data mahasiswa
        $mahasiswa->update($request->all());

        return response()->json([
            'message' => 'Data mahasiswa berhasil diupdate',
            'data' => $mahasiswa
        ], 200);
    }
}
