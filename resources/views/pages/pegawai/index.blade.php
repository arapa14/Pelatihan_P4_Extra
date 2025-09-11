@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Daftar Pegawai</h2>

            <div class="flex items-center gap-3">
                <form action="{{ route('pegawai.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari nama / jabatan / alamat"
                        value="{{ request('search') }}"
                        class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 focus:outline-none" />
                    <select name="golongan_id" class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200">
                        <option value="">Semua Golongan</option>
                        @foreach($golongans as $g)
                            <option value="{{ $g->id }}" @selected(request('golongan_id') == $g->id)>{{ $g->nama }}</option>
                        @endforeach
                    </select>

                    <select name="per_page" class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200">
                        @foreach([5, 10, 15, 25, 50] as $n)
                            <option value="{{ $n }}" @selected(request('per_page', 10) == $n)>{{ $n }} / halaman</option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-3 py-2 bg-blue-600 rounded-lg text-white">Terapkan</button>

                    <a href="{{ route('pegawai.index') }}"
                        class="px-3 py-2 bg-slate-600 rounded-lg text-white ml-2">Reset</a>
                </form>

                @can('crud-data')
                    <a href="{{ route('pegawai.create') }}" class="px-4 py-2 bg-green-600 rounded-lg text-white ml-4">+ Tambah
                        Pegawai</a>
                @endcan
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-700 rounded-lg overflow-hidden">
                <thead class="bg-slate-700 text-slate-300">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Jabatan</th>
                        <th class="px-4 py-2 text-left">Umur</th>
                        <th class="px-4 py-2 text-left">Alamat</th>
                        <th class="px-4 py-2 text-left">Golongan</th>
                        @can('crud-data')
                            <th class="px-4 py-2 text-center">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse ($pegawai as $p)
                        <tr class="hover:bg-slate-700/30">
                            {{-- nomor urut yang memperhitungkan pagination --}}
                            <td class="px-4 py-2">
                                {{ $loop->iteration + ($pegawai->currentPage() - 1) * $pegawai->perPage() }}
                            </td>

                            <td class="px-4 py-2">{{ $p->nama }}</td>
                            <td class="px-4 py-2">{{ $p->jabatan }}</td>
                            <td class="px-4 py-2">{{ $p->umur }}</td>
                            <td class="px-4 py-2">{{ $p->alamat }}</td>
                            <td class="px-4 py-2">{{ $p->golongan->nama ?? '-' }}</td>

                            @can('crud-data')
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('pegawai.edit', $p) }}"
                                        class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 rounded text-white text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('pegawai.destroy', $p) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-2 py-1 bg-red-600 hover:bg-red-700 rounded text-white text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 6 + (Gate::allows('crud-data') ? 1 : 0) }}"
                                class="px-4 py-3 text-center text-slate-400">
                                Belum ada data pegawai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between text-sm text-slate-300">
            <div>
                {{-- Menampilkan info: menampilkan x dari total y --}}
                Menampilkan {{ $pegawai->firstItem() ? $pegawai->firstItem() : 0 }}
                - {{ $pegawai->lastItem() ? $pegawai->lastItem() : 0 }} dari {{ $pegawai->total() }} data
            </div>

            <div>
                {{-- Pagination links (dengan query string karena ->withQueryString() sudah dipanggil) --}}
                {{ $pegawai->links() }}
            </div>
        </div>
    </div>
@endsection