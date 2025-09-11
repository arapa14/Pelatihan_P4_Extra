<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Lembur;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GajiController extends Controller
{
    /**
     * Tampilkan daftar gaji
     */
    public function index()
    {
        $gaji = Gaji::with('pegawai')->latest()->paginate(10);
        return view('pages.gaji.index', compact('gaji'));
    }

    /**
     * Form tambah gaji
     */
    public function create()
    {
        $pegawai = Pegawai::with('golongan')->get();
        return view('pages.gaji.create', compact('pegawai'));
    }

    /**
     * Simpan data gaji baru
     */
    public function store(Request $request)
    {
        Log::info('Store Gaji dimulai', $request->all());

        $validated = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'potongan' => 'nullable|integer|min:0',
            'tanggal_gaji' => 'required|date',
        ]);

        $pegawai = Pegawai::with('golongan')->findOrFail($validated['pegawai_id']);
        $golongan = $pegawai->golongan;

        if (!$golongan) {
            return back()->withErrors(['pegawai_id' => 'Pegawai belum memiliki golongan.']);
        }

        // Cek apakah gaji sudah diproses untuk bulan & tahun tersebut
        $existing = Gaji::where('pegawai_id', $pegawai->id)
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->first();

        if ($existing) {
            return back()->withErrors([
                'tanggal_gaji' => 'Gaji untuk pegawai ini pada bulan & tahun tersebut sudah diproses.'
            ]);
        }

        // Hitung gaji pokok + tunjangan
        $jumlah_gaji =
            ($golongan->gaji_pokok ?? 0) +
            ($golongan->tunjangan_keluarga ?? 0) +
            ($golongan->tunjangan_transport ?? 0) +
            ($golongan->tunjangan_makan ?? 0);

        // Hitung total lembur (override pakai rate_per_jam jika ada)
        $lembur = Lembur::where('pegawai_id', $pegawai->id)
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->get();

        $jumlah_lembur = $lembur->sum(function ($l) use ($golongan) {
            $rate = $l->rate_per_jam ?? $golongan->tarif_lembur_per_jam ?? 0;
            return $l->jumlah_jam * $rate;
        });

        // Potongan
        $potongan = $validated['potongan'] ?? 0;

        // Gaji diterima
        $gaji_diterima = $jumlah_gaji + $jumlah_lembur - $potongan;

        // Simpan snapshot ke tabel gajis
        $gaji = Gaji::create([
            'pegawai_id' => $pegawai->id,
            'jumlah_gaji' => $jumlah_gaji,
            'jumlah_lembur' => $jumlah_lembur,
            'potongan' => $potongan,
            'gaji_diterima' => $gaji_diterima,
            'bulan' => $validated['bulan'],
            'tahun' => $validated['tahun'],
            'tanggal_gaji' => $validated['tanggal_gaji'],
        ]);

        Log::info('Data Gaji berhasil dibuat', $gaji->toArray());

        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil diproses.');
    }

    /**
     * Form edit gaji
     */
    public function edit(Gaji $gaji)
    {
        $pegawai = Pegawai::with('golongan')->get();
        return view('pages.gaji.edit', compact('gaji', 'pegawai'));
    }

    /**
     * Update data gaji
     */
    public function update(Request $request, Gaji $gaji)
    {
        Log::info("Data request update gaji", $request->all());

        try {
            $validated = $request->validate([
                'pegawai_id' => 'required|exists:pegawais,id',
                'bulan' => 'required|numeric|min:1|max:12',
                'tahun' => 'required|numeric|digits:4',
                'potongan' => 'nullable|numeric|min:0',
                'tanggal_gaji' => 'required|date_format:Y-m-d',
            ]);

            $pegawai = Pegawai::with('golongan')->findOrFail($validated['pegawai_id']);
            $golongan = $pegawai->golongan;

            if (!$golongan) {
                return back()->withErrors(['pegawai_id' => 'Pegawai belum memiliki golongan.']);
            }

            // Hitung jumlah gaji pokok + tunjangan
            $jumlah_gaji =
                ($golongan->gaji_pokok ?? 0) +
                ($golongan->tunjangan_keluarga ?? 0) +
                ($golongan->tunjangan_transport ?? 0) +
                ($golongan->tunjangan_makan ?? 0);

            // Hitung total lembur
            $lembur = Lembur::where('pegawai_id', $pegawai->id)
                ->where('bulan', $validated['bulan'])
                ->where('tahun', $validated['tahun'])
                ->get();

            $jumlah_lembur = $lembur->sum(function ($l) use ($golongan) {
                $rate = $l->rate_per_jam ?? $golongan->tarif_lembur_per_jam ?? 0;
                return $l->jumlah_jam * $rate;
            });

            $potongan = $validated['potongan'] ?? 0;

            $validated['jumlah_gaji'] = $jumlah_gaji;
            $validated['jumlah_lembur'] = $jumlah_lembur;
            $validated['gaji_diterima'] = $jumlah_gaji + $jumlah_lembur - $potongan;

            $gaji->update($validated);

            Log::info("Gaji berhasil diperbarui", ['gaji_id' => $gaji->id]);

            return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Gagal update gaji", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data gaji.']);
        }
    }



    /**
     * Hapus data gaji
     */
    public function destroy(Gaji $gaji)
    {
        $gaji->delete();

        Log::warning("Gaji berhasil dihapus", ['gaji_id' => $gaji->id]);

        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil dihapus');
    }
}
