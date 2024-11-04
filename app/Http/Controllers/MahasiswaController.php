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
        //hanya admin yang bisa mengahpus
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat menghapus data.'
            ], 403);
        }
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return response()->json([
            'message' => 'Data deleted successfully'
        ]);
    }
     
}
