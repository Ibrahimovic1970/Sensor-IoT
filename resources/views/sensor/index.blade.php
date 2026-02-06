@extends('layouts.app')

@section('title', 'Data Sensor')

@section('content')
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Data Sensor</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('sensor.create') }}" class="btn btn-primary">Tambah</a>
                <a href="{{ route('sensor.export') }}" class="btn btn-success">Export CSV</a>
            </div>
        </div>

        <form method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="lokasi" value="{{ request('lokasi') }}" class="form-control"
                        placeholder="Cari lokasi...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary">Cari</button>
                </div>
                @if(request('lokasi'))
                    <div class="col-md-4">
                        <a href="{{ route('sensor.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                @endif
            </div>
        </form>

        @if($sensors->isEmpty())
            <p class="text-muted">Belum ada data.</p>
        @else
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Lokasi</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sensors as $s)
                        <tr>
                            <td>{{ $s->nama_sensor }}</td>
                            <td>{{ $s->lokasi ?? '-' }}</td>
                            <td>{{ $s->data }}</td>
                            <td>
                                <button class="btn btn-sm p-0 toggle-status" data-id="{{ $s->id }}" data-status="{{ $s->status }}">
                                    <span class="badge {{ $s->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $s->status ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </button>
                            </td>
                            <td>
                                <a href="{{ route('sensor.edit', $s->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" action="{{ route('sensor.destroy', $s->id) }}" style="display:inline;"
                                    onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @section('scripts')
        <script>
            document.querySelectorAll('.toggle-status').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    const status = btn.dataset.status === '1';
                    const res = await fetch("{{ route('sensor.toggle-status') }}", {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ id, status })
                    });
                    if (res.ok) {
                        btn.dataset.status = status ? '0' : '1';
                        const span = btn.querySelector('span');
                        span.className = status ? 'badge bg-secondary' : 'badge bg-success';
                        span.textContent = status ? 'Nonaktif' : 'Aktif';
                    }
                });
            });
        </script>
    @endsection
@endsection