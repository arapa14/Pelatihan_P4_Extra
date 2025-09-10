<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::all();
        return view('pages.pegawai.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $golongan = Golongan::all();
        return view('pages.pegawai.create', compact('golongan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'umur' => 'required|integer|min:18',
            'alamat' => 'required|string',
            'golongan_id' => 'required|exists:golongans,id',
        ]);

        Pegawai::create($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $golongan = Golongan::all();

        return view('pages.pegawai.edit', [
            'title' => 'Edit Pegawai',
            'active' => 'pegawai',
            'pegawai' => $pegawai,
            'golongan' => $golongan,
        ]);
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'umur' => 'required|integer|min:18',
            'alamat' => 'required|string',
            'golongan_id' => 'required|exists:golongans,id',
        ]);

        $pegawai->update($validated);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}
