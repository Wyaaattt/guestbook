@extends('layout.main')
@section('content')
    <div class="card-header">
        <h2>
            Form Pencatatan Kunjungan
        </h2>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.kunjungan') }}" class="row mb-4">
            <div class="col-md-4">
                <label>Periode Awal</label>
                <input type="date" name="waktu_masuk" class="form-control" value="{{ request('waktu_masuk') }}">
            </div>
            <div class="col-md-4">
                <label>Periode Akhir</label>
                <input type="date" name="waktu_akhir" class="form-control" value="{{ request('waktu_akhir') }}">
            </div>
            <div class="col-md-4">
                <label>&nbsp;</label><br>
                <button class="btn btn-primary" type="submit">Tampilkan</button>
            </div>
        </form>

        @if (isset($statistik) && isset($tren))
            <div class="row">
                <div class="col-md-6">
                    {!! $statistik->container() !!}
                </div>
                <div class="col-md-6">
                    {!! $tren->container() !!}
                </div>
            </div>
        @endif


        <h4 class="mt-4">Detail Kunjungan Per Departemen</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Departemen</th>
                    <th>Kepala Departemen</th>
                    <th>Jumlah Kunjungan</th>
                    <th>Rata-rata Durasi</th>
                    <th>Tamu Paling Sering</th>
                    <th>Instansi Terbanyak</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ $item['kepala_dept'] }}</td>
                        <td>{{ $item['jumlah_kunjungan'] }}</td>
                        <td>{{ $item['rata_rata_durasi'] }} menit</td>
                        <td>{{ $item['tamu_tersering'] }} ({{ $item['jumlah_tamu_tersering'] }}x)</td>
                        <td>{{ $item['instansi_terbanyak'] }} ({{ $item['jumlah_instansi_terbanyak'] }}x)</td>
                        <td class="text-center">
                    {{-- <a href="{{ route('kunjungan.detail', $item['id_departemen']) }}" class="btn btn-info btn-sm">Detail</a> --}}
                    <a href="{{ route('kunjungan.export', $item['id_departemen']) }}" class="btn btn-success btn-sm">Export</a>
                </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
@endsection
@section('scripts')
    <script src="{{ LarapexChart::cdn() }}"></script>
    @if (isset($statistik))
        {!! $statistik->script() !!}
    @endif
    @if (isset($tren))
        {!! $tren->script() !!}
    @endif
@endsection
