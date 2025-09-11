<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $golongan = Golongan::all();
        return view('pages.golongan.index', compact('golongan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.golongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'gaji_pokok' => 'required|integer|min:0',
            'tunjangan_keluarga' => 'required|integer|min:0',
            'tunjangan_transport' => 'required|integer|min:0',
            'tunjangan_makan' => 'required|integer|min:0',
            'tarif_lembur_per_jam' => 'nullable|integer|min:0',
        ]);

        Golongan::create($validated);

        return redirect()->route('golongan.index')->with('success', 'Golongan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Golongan $golongan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Golongan $golongan)
    {
        return view('pages.golongan.edit', compact('golongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Golongan $golongan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'gaji_pokok' => 'required|integer|min:0',
            'tunjangan_keluarga' => 'required|integer|min:0',
            'tunjangan_transport' => 'required|integer|min:0',
            'tunjangan_makan' => 'required|integer|min:0',
            'tarif_lembur_per_jam' => 'nullable|integer|min:0',
        ]);

        $golongan->update($validated);

        return redirect()->route('golongan.index')->with('success', 'Data golongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Golongan $golongan)
    {
        $golongan->delete();

        return redirect()->route('golongan.index')->with('success', 'Data golongan berhasil dihapus.');
    }
}
