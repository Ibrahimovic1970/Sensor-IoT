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
        $request->validate([
            'nama_sensor' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'data' => 'required|string',
        ]);

        DB::table('sensors')->insert([
            'nama_sensor' => $request->nama_sensor,
            'lokasi' => $request->lokasi,
            'data' => $request->data,
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
        if (!$sensor)
            abort(404);
        return view('sensor.edit', compact('sensor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sensor' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'data' => 'required|string',
        ]);

        DB::table('sensors')
            ->where('id', $id)
            ->update([
                'nama_sensor' => $request->nama_sensor,
                'lokasi' => $request->lokasi,
                'data' => $request->data,
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

    public function toggleStatus(Request $request)
    {
        $id = $request->input('id');
        $current = $request->input('status');
        DB::table('sensors')->where('id', $id)->update(['status' => !$current]);
        return response()->json(['success' => true]);
    }

    public function export()
    {
        $sensors = DB::table('sensors')->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=sensor_data_' . date('Y-m-d') . '.csv',
        ];

        $callback = function () use ($sensors) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nama Sensor', 'Lokasi', 'Data', 'Status', 'Dibuat']);
            foreach ($sensors as $s) {
                fputcsv($file, [
                    $s->id,
                    $s->nama_sensor,
                    $s->lokasi ?? '-',
                    $s->data,
                    $s->status ? 'Aktif' : 'Nonaktif',
                    $s->created_at,
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}