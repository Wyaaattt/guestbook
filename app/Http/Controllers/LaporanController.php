<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class LaporanController extends Controller
{
    public function index(Request $request)
    {
        
        $awal = $request->waktu_masuk ? Carbon::createFromFormat('Y-m-d', $request->waktu_masuk)->startOfDay() : Carbon::now()->startOfMonth();
        $akhir = $request->waktu_akhir ? Carbon::createFromFormat('Y-m-d', $request->waktu_akhir)->endOfDay() : Carbon::now()->endOfDay();

        // Statistik Kunjungan per Departemen
        $dataDepartemen = Kunjungan::select('departemens.nama', DB::raw('COUNT(*) as total'))
            ->join('departemens', 'kunjungans.id_departemen', '=', 'departemens.id')
            ->whereBetween('waktu_masuk', [$awal, $akhir])
            ->groupBy('departemens.nama')
            ->get();

        $labelsDepartemen = $dataDepartemen->pluck('nama')->toArray();
        $valuesDepartemen = $dataDepartemen->pluck('total')->toArray();

        $statistik = (new LarapexChart)->pieChart()
            ->setTitle('Statistik Kunjungan per Departemen')
            ->addData($valuesDepartemen)
            ->setLabels($labelsDepartemen);

        // Tren Kunjungan per Hari
        $dataTren = Kunjungan::select(DB::raw('DATE(waktu_masuk) as tanggal'), DB::raw('COUNT(*) as total'))
            ->whereBetween('waktu_masuk', [$awal, $akhir])
            ->groupBy(DB::raw('DATE(waktu_masuk)'))
            ->orderBy('tanggal')
            ->get();

        $labelsTren = $dataTren->pluck('tanggal')->map(function ($tanggal) {
            return Carbon::parse($tanggal)->format('d M');
        })->toArray();

        $valuesTren = $dataTren->pluck('total')->toArray();
        // dd($dataDepartemen, $dataTren);

        $tren = (new LarapexChart)->lineChart()
            ->setTitle('Tren Kunjungan per Hari')
            ->addData('Jumlah Kunjungan', $valuesTren)
            ->setXAxis($labelsTren);
        // \Log::info("Filter tanggal: $awal - $akhir");
        // \Log::info('Total data departemen: ' . $dataDepartemen->count());
        // \Log::info('Total data tren kunjungan: ' . $dataTren->count());

        $departemen = Departemen::with('kunjungan.tamu')->get();
        // mengambil relasi antara departeman dan tamu
        $data = [];

        // 
        foreach ($departemen as $dep) {
            $kunjungan = $dep->kunjungan;

            $jumlahKunjungan = $kunjungan->count();

            $rataDurasi = $kunjungan->filter(function ($item) {
                return $item->waktu_masuk && $item->waktu_keluar;
            })->avg(function ($item) {
                return \Carbon\Carbon::parse($item->waktu_masuk)->diffInMinutes($item->waktu_keluar);
            });

            $groupedTamu = $kunjungan->groupBy(function ($item) {
                return optional($item->tamu)->nama;
            });

            $tamuTersering = $groupedTamu->sortByDesc(function ($group) {
                return $group->count();
            })->first();

            $namaTamuTersering = $tamuTersering ? optional($tamuTersering->first()->tamu)->nama : '-';
            $jumlahTamuTersering = $tamuTersering ? $tamuTersering->count() : 0;

            $groupedInstansi = $kunjungan->groupBy(function ($item) {
                return optional($item->tamu)->instansi;
            });

            $instansiTersering = $groupedInstansi->sortByDesc(function ($group) {
                return $group->count();
            })->first();

            $namaInstansiTersering = $instansiTersering ? optional($instansiTersering->first()->tamu)->instansi : '-';
            $jumlahInstansiTersering = $instansiTersering ? $instansiTersering->count() : 0;
            

            $data[] = [
                'id_departemen' => $dep->id,
                'nama' => $dep->nama,
                'kepala_dept' => $dep->kepala_dept,
                'jumlah_kunjungan' => $jumlahKunjungan,
                'rata_rata_durasi' => round($rataDurasi ?? 0),
                'tamu_tersering' => $namaTamuTersering,
                'jumlah_tamu_tersering' => $jumlahTamuTersering,
                'instansi_terbanyak' => $namaInstansiTersering,
                'jumlah_instansi_terbanyak' => $jumlahInstansiTersering,
            ];
        }

        return view('laporankpd.dashboard', compact('statistik', 'tren', 'data'));
    }

   
}
