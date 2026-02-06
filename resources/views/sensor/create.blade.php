@extends('layouts.app')

@section('title', 'Tambah Data Sensor')

@section('content')
    <div class="card p-4">
        <h1 class="page-title">Tambah Data Sensor</h1>

        <form action="{{ route('sensor.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama_sensor" class="form-label">Nama Sensor</label>
                <input type="text" name="nama_sensor" id="nama_sensor" class="form-control" required
                    placeholder="Contoh: Sensor DHT">
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Contoh: Ruang Server">
            </div>

            <div class="mb-3">
                <label for="data" class="form-label">Data</label>
                <input type="text" name="data" id="data" class="form-control" required placeholder="Contoh: 25°C, 60%">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('sensor.index') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection