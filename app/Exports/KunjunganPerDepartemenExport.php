<?php

namespace App\Exports;

use App\Models\Departemen;
use App\Models\Kunjungan;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KunjunganPerDepartemenExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $departemen = Departemen::with('kunjungan.tamu')->get();
        $data = [];

        foreach ($departemen as $dep) {
            $kunjungan = $dep->kunjungan;

            $jumlahKunjungan = $kunjungan->count();
            $rataDurasi = $kunjungan->avg('durasi');

            // Tamu tersering
            $groupedTamu = $kunjungan->groupBy(fn($item) => optional($item->tamu)->nama);
            $tamuTersering = $groupedTamu->sortByDesc(fn($g) => $g->count())->first();
            $namaTamuTersering = $tamuTersering ? optional($tamuTersering->first()->tamu)->nama : '-';
            $jumlahTamuTersering = $tamuTersering ? $tamuTersering->count() : 0;

            // Instansi terbanyak
            $groupedInstansi = $kunjungan->groupBy(fn($item) => optional($item->tamu)->instansi);
            $instansiTersering = $groupedInstansi->sortByDesc(fn($g) => $g->count())->first();
            $namaInstansiTersering = $instansiTersering ? optional($instansiTersering->first()->tamu)->instansi : '-';
            $jumlahInstansiTersering = $instansiTersering ? $instansiTersering->count() : 0;

            $data[] = [
                $dep->nama,
                $dep->kepala_dept,
                $jumlahKunjungan,
                round($rataDurasi ?? 0) . ' menit',
                "$namaTamuTersering ($jumlahTamuTersering x)",
                "$namaInstansiTersering ($jumlahInstansiTersering x)"
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Departemen',
            'Kepala Departemen',
            'Jumlah Kunjungan',
            'Rata-rata Durasi',
            'Tamu Paling Sering',
            'Instansi Terbanyak',
        ];
        //proses heading excel
    }
}
