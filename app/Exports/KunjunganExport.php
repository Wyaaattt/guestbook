<?php

namespace App\Exports;

use App\Models\Kunjungan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KunjunganExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Kunjungan::with('tamu', 'departemen')->get()->map(function ($item) {
            return [
                'Nama Tamu' => $item->tamu->nama ?? '-',
                'Instansi' => $item->tamu->instansi ?? '-',
                'Departemen' => $item->departemen->nama ?? '-',
                'Bertemu Dengan' => $item->bertemu_dengan,
                'Tujuan' => $item->tujuan,
                'Waktu Masuk' => $item->waktu_masuk,
                'Waktu Keluar' => $item->waktu_keluar,
                'Status' => $item->status,
            ];
        });
        // prose untuk mengambil data 
    }

    public function headings(): array
    {
        return [
            'Nama Tamu',
            'Instansi',
            'Departemen',
            'Bertemu Dengan',
            'Tujuan',
            'Waktu Masuk',
            'Waktu Keluar',
            'Status',
        ];
        //proses untuk heading excel
    }
}
