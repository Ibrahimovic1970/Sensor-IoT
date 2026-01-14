<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorController extends Controller
{
    /**
     * Menampilkan semua data sensor.
     */
    public function index()
    {
        $sensors = DB::table('sensors')->get();
        return view('sensor.index', compact('sensors'));
    }

    /**
     * Menampilkan form tambah sensor.
     */
    public function create()
    {
        return view('sensor.create');
    }

    /**
     * Menyimpan data sensor baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'nama_sensor' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'data' => 'required|string',
        ]);

        // Simpan ke tabel sensors
        DB::table('sensors')->insert([
            'nama_sensor' => $validated['nama_sensor'],
            'lokasi' => $validated['lokasi'],
            'data' => $validated['data'],
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('sensor.index')
            ->with('success', 'Data sensor berhasil ditambahkan!');
    }

    /**
     * Menghapus data sensor berdasarkan ID.
     */
    public function destroy($id)
    {
        DB::table('sensors')->where('id', $id)->delete();

        return redirect()->route('sensor.index')
            ->with('success', 'Data sensor berhasil dihapus!');
    }
}