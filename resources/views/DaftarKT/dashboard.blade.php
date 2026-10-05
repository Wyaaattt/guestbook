@extends('layout.main')
@section('content')
    <div class="card-header">
        <h2>
            Form Pencatatan Kunjungan
        </h2>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-1">
                <form method="GET" action="{{ route('Kunjungan-Tamu.index') }}">
                    <select name="perPage" class="form-control" onchange="this.form.submit()">
                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
            </div>
            <div class="col-md-3">
                <input type="date" name="waktu_masuk" id="waktu_masuk" value="{{ request('waktu_masuk') }}"
                    class="form-control" onchange="this.form.submit()">
            </div>
            <div class="col-md-3">
                <select name="id_departemen" id="id_departemen" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Semua Departemen --</option>
                    @foreach ($departemen as $d)
                        <option value="{{ $d->id }}" {{ request('id_departemen') == $d->id ? 'selected' : '' }}>
                            {{ $d->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Semua Status --</option>
                    <option value="Check-In" {{ request('status') == 'Check-In' ? 'selected' : '' }}>Check In</option>
                    <option value="Check-Out" {{ request('status') == 'Check-Out' ? 'selected' : '' }}>Check Out</option>
                </select>
            </div>
            <div class="col-md-2">
                <a href="{{ route('Kunjungan-Tamu.export_kunjungan') }}" class="btn btn-success mb-3 float-end btn-sm">
                    Export Excel
                </a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Tamu</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Instansi</th>
                    <th scope="col">Departemen</th>
                    <th scope="col">Bertemu</th>
                    <th scope="col">Tujuan</th>
                    <th scope="col">Waktu Masuk</th>
                    <th scope="col">Waktu Keluar</th>
                    <th scope="col">Durasi</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <th scope="row"><img
                                src="{{ $d->tamu->foto ? asset('storage/' . $d->tamu->foto) : asset('default.jpg') }}"
                                width="100" alt="Foto Tamu">
                        </th>
                        <td>{{ $d->tamu->nama }}</td>
                        <td>{{ $d->tamu->instansi }}</td>
                        <td>{{ $d->departemen->nama }}</td>
                        <td>{{ $d->bertemu_dengan }}</td>
                        <td>{{ $d->tujuan }}</td>
                        <td>{{ $d->waktu_masuk }}</td>
                        <td>{{ $d->waktu_keluar }}</td>
                        <td>
                            @if ($d->waktu_keluar)
                                @php
                                    $masuk = \Carbon\Carbon::parse($d->waktu_masuk);
                                    $keluar = \Carbon\Carbon::parse($d->waktu_keluar);
                                    $totalMenit = $masuk->diffInMinutes($keluar);
                                    $jam = floor($totalMenit / 60);
                                    $menit = $totalMenit % 60;
                                @endphp
                                {{ $jam }} jam {{ $menit }} menit
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if ($d->status == 'Check-In')
                                <span class="badge text-bg-success">{{ $d->status }}</span>
                            @else
                                <span class="badge text-bg-secondary">{{ $d->status }}</span>
                            @endif
                        </td>
                        <td>
                            @if ($d->status == 'Check-In')
                                <form action="{{ route('Kunjungan-Tamu.update', $d->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-warning">Check-Out</button>
                                </form>
                            @elseif ($d->status == 'Check-Out')
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Detail
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ...
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll(
                'input[name="waktu_masuk"], select[name="id_departemen"], select[name="status"]');

            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    const status = document.querySelector('select[name="status"]').value;
                    const id_departemen = document.querySelector('select[name="id_departemen"]')
                        .value;
                    const waktu_masuk = document.querySelector('input[name="waktu_masuk"]').value;

                    const url = new URL(window.location.href);
                    if (status) url.searchParams.set('status', status);
                    else url.searchParams.delete('status');
                    if (id_departemen) url.searchParams.set('id_departemen', id_departemen);
                    else url.searchParams.delete('id_departemen');
                    if (waktu_masuk) url.searchParams.set('waktu_masuk', waktu_masuk);
                    else url.searchParams.delete('waktu_masuk');

                    window.location.href = url;
                });
            });
        });
    </script>
@endsection
