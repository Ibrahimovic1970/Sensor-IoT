@extends('layouts.app')

@section('title', 'Edit Device')

@section('content')
    <div class="card p-4">
        <h1 class="page-title">Edit Device</h1>

        <form action="{{ route('device.update', $device->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="serial_number" class="form-label">Serial Number</label>
                <input type="text" name="serial_number" id="serial_number" class="form-control"
                    value="{{ old('serial_number', $device->serial_number) }}" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('device.index') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection