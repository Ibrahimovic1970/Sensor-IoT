@extends('layouts.app')

@section('title', 'Edit Data Sensor')

@section('content')
    <div class="card p-4">
        <h1 class="page-title">Edit Data Sensor</h1>

        <form action="{{ route('sensor.update', $sensor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_sensor" class="form-label">Nama Sensor</label>
                <input type="text" name="nama_sensor" id="nama_sensor" class="form-control"
                    value="{{ old('nama_sensor', $sensor->nama_sensor) }}" required placeholder="Contoh: Sensor DHT">
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" class="form-control"
                    value="{{ old('lokasi', $sensor->lokasi) }}" placeholder="Contoh: Ruang Server, Lantai 2">
            </div>

            <div class="mb-3">
                <label for="data" class="form-label">Data</label>
                <input type="text" name="data" id="data" class="form-control" value="{{ old('data', $sensor->data) }}"
                    required placeholder="Contoh: 25°C, 60%">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('sensor.index') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection