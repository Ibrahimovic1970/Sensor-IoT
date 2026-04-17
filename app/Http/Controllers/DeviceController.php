<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = DB::table('devices')->get();
        return view('device.index', compact('devices'));
    }

    public function create()
    {
        return view('device.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|max:255|unique:devices',
        ]);

        DB::table('devices')->insert([
            'serial_number' => $request->serial_number,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('device.index')
            ->with('success', 'Device berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $device = DB::table('devices')->where('id', $id)->first();
        if (!$device) {
            abort(404);
        }
        return view('device.edit', compact('device'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'serial_number' => 'required|string|max:255|unique:devices,serial_number,' . $id,
        ]);

        DB::table('devices')
            ->where('id', $id)
            ->update([
                'serial_number' => $request->serial_number,
                'updated_at' => now(),
            ]);

        return redirect()->route('device.index')
            ->with('success', 'Device berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('devices')->where('id', $id)->delete();
        return redirect()->route('device.index')
            ->with('success', 'Device berhasil dihapus!');
    }
}