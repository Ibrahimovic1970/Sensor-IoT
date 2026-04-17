@extends('layouts.app')

@section('title', 'Tambah Device')

@section('content')
    <div class="card p-4">
        <h1 class="page-title">Tambah Device</h1>

        <form action="{{ route('device.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="serial_number" class="form-label">Serial Number</label>
                <input type="text" name="serial_number" id="serial_number" class="form-control" required
                    placeholder="Contoh: SN-2026-001">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('device.index') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection