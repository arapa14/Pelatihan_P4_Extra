@extends('layouts.app')

@section('title', 'Data Golongan')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Daftar Golongan</h2>

            @can('crud-data')
                <a href="{{ route('golongan.create') }}"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white shadow">
                    + Tambah Golongan
                </a>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-700 rounded-lg overflow-hidden">
                <thead class="bg-slate-700 text-slate-300">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Gaji Pokok</th>
                        <th class="px-4 py-2 text-left">Tunjangan Keluarga</th>
                        <th class="px-4 py-2 text-left">Tunjangan Transport</th>
                        <th class="px-4 py-2 text-left">Tunjangan Makan</th>
                        <th class="px-4 py-2 text-left">Tarif Lembur /Jam</th>
                        @can('crud-data')
                            <th class="px-4 py-2 text-center">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse ($golongan as $p)
                        <tr class="hover:bg-slate-700/30">
                            <td class="px-4 py-2">{{ $p->nama }}</td>
                            <td class="px-4 py-2">{{ $p->gaji_pokok }}</td>
                            <td class="px-4 py-2">{{ $p->tunjangan_keluarga }}</td>
                            <td class="px-4 py-2">{{ $p->tunjangan_transport }}</td>
                            <td class="px-4 py-2">{{ $p->tunjangan_makan }}</td>
                            <td class="px-4 py-2">{{ $p->tarif_lembur_per_jam }}</td>
                            @can('crud-data')
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('golongan.edit', $p) }}"
                                        class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 rounded text-white text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('golongan.destroy', $p) }}" method="POST" class="inline">
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
                                Belum ada data golongan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection