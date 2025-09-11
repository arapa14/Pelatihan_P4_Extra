@extends('layouts.app')

@section('title', 'Edit Lembur')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg">
        <h2 class="text-xl font-semibold mb-6">Edit Data Lembur</h2>

        <form action="{{ route('lembur.update', $lembur) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-slate-300 mb-1">Pegawai</label>
                <select name="pegawai_id" class="w-full rounded-lg p-2 bg-slate-700 text-white">
                    @foreach($pegawai as $p)
                        <option value="{{ $p->id }}" {{ $lembur->pegawai_id == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }} - {{ $p->jabatan }}
                        </option>
                    @endforeach
                </select>
                @error('pegawai_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="block text-slate-300 mb-1">Bulan</label>
                    <input type="number" name="bulan" min="1" max="12" value="{{ old('bulan', $lembur->bulan) }}"
                        class="w-full rounded-lg p-2 bg-slate-700 text-white">
                    @error('bulan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
                <div class="w-1/2">
                    <label class="block text-slate-300 mb-1">Tahun</label>
                    <input type="number" name="tahun" min="2000" max="2100" value="{{ old('tahun', $lembur->tahun) }}"
                        class="w-full rounded-lg p-2 bg-slate-700 text-white">
                    @error('tahun') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-slate-300 mb-1">Jumlah Jam</label>
                <input type="number" name="jumlah_jam" min="0" value="{{ old('jumlah_jam', $lembur->jumlah_jam) }}"
                    class="w-full rounded-lg p-2 bg-slate-700 text-white">
                @error('jumlah_jam') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-slate-300 mb-1">Rate per Jam</label>
                <input type="number" name="rate_per_jam" min="0" value="{{ old('rate_per_jam', $lembur->rate_per_jam) }}"
                    class="w-full rounded-lg p-2 bg-slate-700 text-white">
                @error('rate_per_jam') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('lembur.index') }}" class="px-4 py-2 bg-slate-600 rounded-lg text-white">Batal</a>
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white">
                    Update
                </button>
            </div>
        </form>
    </div>
@endsection