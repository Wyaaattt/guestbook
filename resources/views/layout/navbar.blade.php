<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid bg-primary">
        <a class="navbar-brand" style="color: white" href="#">Buku Tamu Digital</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active"style="color: white" aria-current="page" href="#">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"style="color: white" href="{{ route('FormPBT.create') }}">Daftar Tamu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"style="color: white" href="{{ route('Kunjungan-Tamu.create') }}">Catat Kunjungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: white"href="{{ route('Kunjungan-Tamu.index') }}">Daftar Kunjungan Kunjungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"style="color: white" href="{{ route('laporan.kunjungan') }}">Laporan</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
