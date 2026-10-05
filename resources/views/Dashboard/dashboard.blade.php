@extends('layout.main')
@section('content')
    @extends('layout.navbar')
    <h1 class="text-center">Selamat Datang</h1>
    <p class="text-center">Sistem Buku Tamu Digital</p>
    <hr>
    <div class="row mb-4 justify-content-center">
        <div class="col-md-5 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Tamu Baru</h5>
                    <p class="card-text">Belum pernah berkunjung sebelumnya?</p>
                    <a href="{{ route('FormPBT.create') }}" class="btn btn-primary">Daftar Tamu Baru</a>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Tamu Terdaftar</h5>
                    <p class="card-text">Sudah pernah berkunjung sebelumnya?</p>
                    <a href="{{ route('Kunjungan-Tamu.create') }}" class="btn btn-primary">Catat Kunjungan</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-primary">{{ $kunjunganHariIni ?? 0 }}</h3>
                    <p>Kunjungan Hari Ini</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-primary">{{ $totalTamu ?? 0 }}</h3>
                    <p>Total Tamu</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-primary">{{ $instansiTerdafar ?? 0 }}</h3>
                    <p>Instansi Terdaftar</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-primary">{{ $totalDepartemen ?? 0 }}</h3>
                    <p>Departemen</p>
                </div>
            </div>
        </div>
    </div>
@endsection
