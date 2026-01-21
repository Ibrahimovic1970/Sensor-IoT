@extends('layouts.app')

@section('title', 'Data Sensor')

@section('content')
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Data Sensor</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('sensor.create') }}" class="btn btn-primary">Tambah Data Sensor</a>
                <a href="{{ route('sensor.export') }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-arrow-down"></i> Export CSV
                </a>
            </div>
        </div>

        <!-- Form Pencarian Lokasi -->
        <form method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-6">
                    <label for="lokasi" class="form-label">Cari Berdasarkan Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ request('lokasi') }}"
                        placeholder="Masukkan lokasi...">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary w-100">Cari</button>
                </div>
                @if(request('lokasi'))
                    <div class="col-md-4 d-flex align-items-end">
                        <a href="{{ route('sensor.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                @endif
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
                            <th>Lokasi</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sensors as $sensor)
                            <tr>
                                <td>{{ $sensor->nama_sensor }}</td>
                                <td>{{ $sensor->lokasi ?? '-' }}</td>
                                <td>{{ $sensor->data }}</td>
                                <td>
                                    <button class="btn btn-sm toggle-status" data-id="{{ $sensor->id }}"
                                        data-status="{{ $sensor->status }}" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">
                                        @if($sensor->status)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </button>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('sensor.edit', $sensor->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('sensor.destroy', $sensor->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus sensor ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-x-circle"></i> Hapus
                                            </button>
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

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButtons = document.querySelectorAll('.toggle-status');

            toggleButtons.forEach(button => {
                button.addEventListener('click', async function () {
                    const id = this.dataset.id;
                    const currentStatus = parseInt(this.dataset.status);
                    const newStatus = !currentStatus;

                    try {
                        const response = await fetch("{{ route('sensor.toggle-status') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id: id,
                                status: currentStatus
                            })
                        });

                        if (response.ok) {
                            // Update tampilan langsung
                            this.dataset.status = newStatus;
                            const badge = this.querySelector('span');
                            if (newStatus) {
                                badge.className = 'badge bg-success';
                                badge.textContent = 'Aktif';
                            } else {
                                badge.className = 'badge bg-secondary';
                                badge.textContent = 'Nonaktif';
                            }
                        } else {
                            alert('Gagal mengubah status.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah status.');
                    }
                });
            });
        });
    </script>
@endsection