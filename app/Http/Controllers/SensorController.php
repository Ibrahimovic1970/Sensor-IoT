<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index()
    {
        $sensors = Sensor::all();
        return view('sensor.index', compact('sensors'));
    }

    public function create()
    {
        return view('sensor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sensor' => 'required|string|max:255',
            'data' => 'required|integer',
        ]);

        Sensor::create($validated);

        return redirect()->route('sensor.index')->with('success', 'Data sensor berhasil ditambahkan!');
    }
}