<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class LemburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Lembur::with('pegawai');

        // search by pegawai name
        if ($search = $request->query('search')) {
            $query->whereHas('pegawai', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        // filter bulan (1-12) and tahun
        if ($bulan = $request->query('bulan')) {
            $query->where('bulan', $bulan);
        }
        if ($tahun = $request->query('tahun')) {
            $query->where('tahun', $tahun);
        }

        // filter rate_per_jam range
        if ($min = $request->query('rate_min')) {
            $query->where('rate_per_jam', '>=', (int) $min);
        }
        if ($max = $request->query('rate_max')) {
            $query->where('rate_per_jam', '<=', (int) $max);
        }

        // per page
        $perPage = (int) $request->query('per_page', 10);
        $perPage = $perPage > 0 ? $perPage : 10;

        // ordering: terbaru dulu (tahun desc, bulan desc)
        $lembur = $query->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.lembur.index', compact('lembur'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();
        return view('pages.lembur.create', compact('pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'jumlah_jam' => 'required|integer|min:0',
            'rate_per_jam' => 'required|integer|min:0',
        ]);

        Lembur::create($validated);

        return redirect()->route('lembur.index')->with('success', 'Data lembur berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Lembur $lembur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lembur $lembur)
    {
        $pegawai = Pegawai::all();
        return view('pages.lembur.edit', compact('lembur', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lembur $lembur)
    {
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'jumlah_jam' => 'required|integer|min:0',
            'rate_per_jam' => 'required|integer|min:0',
        ]);

        $lembur->update($validated);

        return redirect()->route('lembur.index')->with('success', 'Data lembur berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lembur $lembur)
    {
        $lembur->delete();
        return redirect()->route('lembur.index')->with('success', 'Data lembur berhasil dihapus.');
    }
}
