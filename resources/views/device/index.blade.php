@extends('layouts.app')

@section('title', 'Daftar Device')

@section('content')
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Daftar Device</h1>
            <a href="{{ route('device.create') }}" class="btn btn-primary">Tambah Device</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($devices->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted">Belum ada device.</p>
                <a href="{{ route('device.create') }}" class="btn btn-outline-primary mt-3">Tambah Device Pertama</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Serial Number</th>
                            <th>Waktu Pembuatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($devices as $device)
                            <tr>
                                <td>{{ $device->id }}</td>
                                <td>{{ $device->serial_number }}</td>
                                <td>{{ $device->created_at }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('device.edit', $device->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('device.destroy', $device->id) }}"
                                            style="display:inline;" onsubmit="return confirm('Hapus device ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection