<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SensorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('lokasi');

        $query = DB::table('sensors');

        if ($search) {
            $query->where('lokasi', 'like', "%{$search}%");
        }

        $sensors = $query->get();

        return view('sensor.index', compact('sensors', 'search'));
    }

    public function create()
    {
        return view('sensor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sensor' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'data' => 'required|string',
        ]);

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

    public function edit($id)
    {
        $sensor = DB::table('sensors')->where('id', $id)->first();

        if (!$sensor) {
            abort(404);
        }

        return view('sensor.edit', compact('sensor'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_sensor' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'data' => 'required|string',
        ]);

        DB::table('sensors')
            ->where('id', $id)
            ->update([
                'nama_sensor' => $validated['nama_sensor'],
                'lokasi' => $validated['lokasi'],
                'data' => $validated['data'],
                'updated_at' => now(),
            ]);

        return redirect()->route('sensor.index')
            ->with('success', 'Data sensor berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('sensors')->where('id', $id)->delete();

        return redirect()->route('sensor.index')
            ->with('success', 'Data sensor berhasil dihapus!');
    }

    // 🔁 Toggle Status Aktif/Nonaktif
    public function toggleStatus(Request $request)
    {
        $id = $request->input('id');
        $currentStatus = $request->input('status'); // 1 atau 0

        DB::table('sensors')
            ->where('id', $id)
            ->update(['status' => !$currentStatus]);

        return response()->json(['success' => true]);
    }

    // 📤 Export ke CSV
    public function export()
    {
        $sensors = DB::table('sensors')->get();

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=sensor_data_' . date('Y-m-d') . '.csv',
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        $callback = function () use ($sensors) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nama Sensor', 'Lokasi', 'Data', 'Status', 'Dibuat', 'Diperbarui']);

            foreach ($sensors as $sensor) {
                fputcsv($file, [
                    $sensor->id,
                    $sensor->nama_sensor,
                    $sensor->lokasi ?? '-',
                    $sensor->data,
                    $sensor->status ? 'Aktif' : 'Nonaktif',
                    $sensor->created_at,
                    $sensor->updated_at,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}