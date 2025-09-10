@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')
    <div class="max-w-2xl mx-auto bg-slate-800 p-6 rounded-2xl shadow-lg">
        <h2 class="text-xl font-semibold mb-6">Tambah Pegawai</h2>

        <form action="{{ route('pegawai.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="nama" class="block text-sm mb-1">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    class="w-full px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:ring focus:ring-blue-500">
                @error('nama')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jabatan" class="block text-sm mb-1">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}"
                    class="w-full px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:ring focus:ring-blue-500">
                @error('jabatan')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="umur" class="block text-sm mb-1">Umur</label>
                <input type="number" name="umur" id="umur" value="{{ old('umur') }}"
                    class="w-full px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:ring focus:ring-blue-500">
                @error('umur')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="alamat" class="block text-sm mb-1">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3"
                    class="w-full px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:ring focus:ring-blue-500">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="golongan_id" class="block text-sm mb-1">Golongan</label>
                <select name="golongan_id" id="golongan_id"
                    class="w-full px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:ring focus:ring-blue-500">
                    <option value="">-- Pilih Golongan --</option>
                    @foreach ($golongan as $g)
                        <option value="{{ $g->id }}" {{ old('golongan_id') == $g->id ? 'selected' : '' }}>
                            {{ $g->nama }}
                        </option>
                    @endforeach
                </select>
                @error('golongan_id')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('pegawai.index') }}"
                    class="px-4 py-2 rounded-lg bg-slate-600 hover:bg-slate-500 text-white">Batal</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white shadow">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
