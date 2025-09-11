@extends('layouts.app')

@section('title', 'Tambah Golongan')

@section('content')
    <div class="max-w-2xl mx-auto bg-slate-800 p-6 rounded-2xl shadow-lg">
        <h2 class="text-xl font-semibold mb-6">Tambah Golongan</h2>

        <form action="{{ route('golongan.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="nama" class="block text-sm mb-1">Nama Golongan</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    class="w-full px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:ring focus:ring-blue-500">
                @error('nama')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="gaji_pokok" class="block text-sm mb-1">Gaji Pokok</label>
                <input type="number" name="gaji_pokok" id="gaji_pokok" value="{{ old('gaji_pokok') }}"
                    class="w-full px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:ring focus:ring-blue-500">
                @error('gaji_pokok')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tunjangan_keluarga" class="block text-sm mb-1">Tunjangan Keluarga</label>
                <input type="number" name="tunjangan_keluarga" id="tunjangan_keluarga"
                    value="{{ old('tunjangan_keluarga') }}"
                    class="w-full px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:ring focus:ring-blue-500">
                @error('tunjangan_keluarga')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tunjangan_transport" class="block text-sm mb-1">Tunjangan Transport</label>
                <input type="number" name="tunjangan_transport" id="tunjangan_transport"
                    value="{{ old('tunjangan_transport') }}"
                    class="w-full px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:ring focus:ring-blue-500">
                @error('tunjangan_transport')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tunjangan_makan" class="block text-sm mb-1">Tunjangan Makan</label>
                <input type="number" name="tunjangan_makan" id="tunjangan_makan" value="{{ old('tunjangan_makan') }}"
                    class="w-full px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:ring focus:ring-blue-500">
                @error('tunjangan_makan')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tarif_lembur_per_jam" class="block text-sm mb-1">Tarif Lembur per Jam (opsional)</label>
                <input type="number" name="tarif_lembur_per_jam" id="tarif_lembur_per_jam"
                    value="{{ old('tarif_lembur_per_jam') }}"
                    class="w-full px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:ring focus:ring-blue-500">
                @error('tarif_lembur_per_jam')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('golongan.index') }}"
                    class="px-4 py-2 rounded-lg bg-slate-600 hover:bg-slate-500 text-white">Batal</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white shadow">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection