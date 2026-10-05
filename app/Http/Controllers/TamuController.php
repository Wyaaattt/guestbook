<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;

class TamuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('formpbt/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // Untuk prose menambahkan data
    {
        $request->validate([
            'nama' => 'required',
            'instansi' => 'required',
            'telepon' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);
        // dd($request->all());

        // proses untuk menyimpan yang diupload oleh user terdapat 2 opsi null atau data
        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto_tamu', 'public');
        }
        //proses pembuatan data tamu
        Tamu::create([
            'nama' => $request->nama,
            'instansi' => $request->instansi,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'foto' => $foto,
            'tanggal_daftar' => now()->format('Y-m-d'),
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tamu $tamu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tamu $tamu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tamu $tamu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tamu $tamu)
    {
        //
    }
}
