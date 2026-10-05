<?php

namespace App\Http\Controllers;

use App\Exports\KunjunganExport;
use App\Exports\KunjunganPerDepartemenExport;
use App\Models\Departemen;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use App\Models\Tamu;
use Maatwebsite\Excel\Facades\Excel;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // proses filter 
        $waktu_masuk = $request->input('waktu_masuk');
        $id_departemen = $request->input('id_departemen');
        $status = $request->input('status');
        $perPage = $request->input('perPage', 10);


        $kunjungan = Kunjungan::with(['tamu', 'departemen']);
        // mengambil data relasi kunjungan dengan tamu. departemen

        if ($waktu_masuk) {
            $kunjungan->whereDate('waktu_masuk', date('Y-m-d', strtotime($waktu_masuk)));
        }

        if ($id_departemen) {
            $kunjungan->where('id_departemen', $id_departemen);
        }

        if ($status) {
            $kunjungan->where('status', $status);
        }

        $data = $kunjungan->paginate($perPage)->appends($request->only('perpage'));

        // Kirim data departemen ke view 
        $departemen = Departemen::all();

        return view('daftarkt.dashboard', compact('data', 'departemen', 'waktu_masuk', 'id_departemen', 'status'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // proses fitur search
        $search = $request->input('search');
        $data = Tamu::query()
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('instansi', 'like', "%{$search}%");
            })
            ->get();
        $departemen = Departemen::all();

        return view('formpk/create', compact('data', 'search', 'departemen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //Prose membuat kunjungan
    {
        $request->validate([
            'id_tamu' => 'required|exists:tamus,id',
            'id_departemen' => 'required|exists:departemens,id',
            'tujuan' => 'required|string',
            'bertemu_dengan' => 'required|string',
            'waktu_masuk' => 'required|date',
        ]);

        // proses pembuatan data
        Kunjungan::create([
            'id_tamu' => $request->id_tamu,
            'id_departemen' => $request->id_departemen,
            'tujuan' => $request->tujuan,
            'bertemu_dengan' => $request->bertemu_dengan,
            'waktu_masuk' => $request->waktu_masuk,
            'status' => 'Check-In',
        ]);
        

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Kunjungan $kunjungan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kunjungan $kunjungan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        // prose update ketika check out
        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->waktu_keluar = now();
        $kunjungan->status = 'Check-Out';
        $kunjungan->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kunjungan $kunjungan)
    {
        //
    }

    public function export_kunjungan()
    {
        // proses download excel
        return Excel::download(new KunjunganExport, 'kunjungan.xlsx');
    }
    public function exportdepartemen()
    {   
        // proses download excel
        return Excel::download(new KunjunganPerDepartemenExport, 'kunjungan_departemen.xlsx');
    }
}
