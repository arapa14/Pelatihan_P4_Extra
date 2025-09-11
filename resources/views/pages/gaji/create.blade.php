@extends('layouts.app')

@section('title', 'Tambah Data Gaji')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg max-w-3xl mx-auto">
        <h2 class="text-xl font-semibold mb-6">Tambah Data Gaji</h2>

        <form action="{{ route('gaji.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Pegawai --}}
            <div>
                <label for="pegawai_id" class="block text-slate-300 mb-1">Pegawai</label>
                <select name="pegawai_id" id="pegawai_id" class="w-full rounded-lg px-3 py-2 bg-slate-700 text-white">
                    <option value="">-- Pilih Pegawai --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}" {{ old('pegawai_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }} ({{ $p->golongan->nama ?? '-' }})
                        </option>
                    @endforeach
                </select>
                @error('pegawai_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Bulan --}}
            <div>
                <label for="bulan" class="block text-slate-300 mb-1">Bulan</label>
                <input type="number" name="bulan" id="bulan" min="1" max="12"
                    class="w-full rounded-lg px-3 py-2 bg-slate-700 text-white" value="{{ old('bulan') }}">
                @error('bulan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Tahun --}}
            <div>
                <label for="tahun" class="block text-slate-300 mb-1">Tahun</label>
                <input type="number" name="tahun" id="tahun" class="w-full rounded-lg px-3 py-2 bg-slate-700 text-white"
                    value="{{ old('tahun', date('Y')) }}">
                @error('tahun') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Potongan --}}
            <div>
                <label for="potongan" class="block text-slate-300 mb-1">Potongan</label>
                <input type="number" name="potongan" id="potongan" min="0"
                    class="w-full rounded-lg px-3 py-2 bg-slate-700 text-white" value="{{ old('potongan', 0) }}">
                @error('potongan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal Gaji --}}
            <div>
                <label for="tanggal_gaji" class="block text-slate-300 mb-1">Tanggal Gaji</label>
                <input type="date" name="tanggal_gaji" id="tanggal_gaji"
                    class="w-full rounded-lg px-3 py-2 bg-slate-700 text-white"
                    value="{{ old('tanggal_gaji', date('Y-m-d')) }}">
                @error('tanggal_gaji') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('gaji.index') }}"
                    class="px-4 py-2 bg-slate-600 hover:bg-slate-700 rounded-lg text-white mr-2">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white">Simpan</button>
            </div>
        </form>
    </div>
@endsection