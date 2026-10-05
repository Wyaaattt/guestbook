@extends('layout.main')
@section('content')
    <div class="card-header">
        <h2>
            Form Pencatatan Kunjungan
        </h2>
    </div>
    <div class="card-body">
        <h4>Cari Tamu</h4>
        {{-- Form PENCARIAN, dipisahkan --}}
        <form action="{{ route('Kunjungan-Tamu.create') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Masukkan nama atau instansi"
                    value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit" id="button-addon2">Cari</button>
            </div>
        </form>

        {{-- Form CHECK-IN --}}
        <form action="{{ route('Kunjungan-Tamu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if (request('search'))
                @if ($data->count() > 0)
                    @foreach ($data as $tamu)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/' . $tamu->foto) }}" alt="Foto Tamu" class="img-fluid">
                                    </div>
                                    <div class="col-md-4">
                                        <h5>{{ $tamu->nama }}</h5>
                                        <p>Instansi: {{ $tamu->instansi }}</p>
                                        <p>Email: {{ $tamu->email }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Telepon: {{ $tamu->telepon }}</p>
                                        <p>Tanggal Daftar: {{ $tamu->tanggal_daftar }}</p>
                                    </div>
                                </div>

                                <input type="hidden" name="id_tamu" value="{{ $tamu->id }}">

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Tujuan Kunjungan</label>
                                <input type="text" name="tujuan" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Departemen Tujuan</label>
                                <select name="id_departemen" class="form-select" required>
                                    <option value="">Pilih Departemen</option>
                                    @foreach ($departemen as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label>Bertemu Dengan</label>
                                <input type="text" name="bertemu_dengan" class="form-control" required>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label>Waktu Masuk</label>
                                <input type="datetime-local" name="waktu_masuk" class="form-control" required>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-md-12 text-end mt-2">
                        <button class="btn btn-secondary" type="reset">Batal</button>
                        <button class="btn btn-success" type="submit">Check-In</button>
                    </div>
                @else
                    <div class="alert alert-warning text-center">Tidak ada data ditemukan.</div>
                @endif
            @endif
        </form>

    </div>
@endsection
