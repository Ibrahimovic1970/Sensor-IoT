@extends('layouts.app')

@section('title', 'Data Sensor')

@section('content')
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Data Sensor</h1>
            <a href="{{ route('sensor.create') }}" class="btn btn-primary">Tambah Data Sensor</a>
        </div>

        @if($sensors->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted">Belum ada data sensor.</p>
                <a href="{{ route('sensor.create') }}" class="btn btn-outline-primary mt-3">Tambah Sensor Pertama</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Sensor</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sensors as $sensor)
                            <tr>
                                <td>{{ $sensor->nama_sensor }}</td>
                                <td>{{ $sensor->data }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection