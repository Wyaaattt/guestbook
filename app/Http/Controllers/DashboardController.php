<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Tamu;
use App\Models\Departemen;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        //proses dashboard statik
        $kunjunganHariIni = Kunjungan::whereDate('waktu_masuk', Carbon::today())->count();
        $totalTamu = Tamu::count();
        $instansiTerdafar = Tamu::distinct('instansi')->count('instansi');
        $totalDepartemen = Departemen::count();

        return view('dashboard.dashboard', compact(
            'kunjunganHariIni',
            'totalTamu',
            'instansiTerdafar',
            'totalDepartemen'
        ));
    }
}
