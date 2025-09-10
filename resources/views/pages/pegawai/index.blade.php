@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Daftar Pegawai</h2>

            @can('crud-data')
                <a href="{{ route('pegawai.create') }}"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white shadow">
                    + Tambah Pegawai
                </a>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-700 rounded-lg overflow-hidden">
                <thead class="bg-slate-700 text-slate-300">
                    <tr>
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
                                            class="btn-delete px-2 py-1 bg-red-600 hover:bg-red-700 rounded text-white text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-slate-400">
                                Belum ada data pegawai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
