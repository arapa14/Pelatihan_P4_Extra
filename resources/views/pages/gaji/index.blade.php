@extends('layouts.app')

@section('title', 'Data Gaji')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Daftar Gaji</h2>

            @can('crud-data')
                <a href="{{ route('gaji.create') }}"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white shadow">
                    + Tambah Gaji
                </a>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-700 rounded-lg overflow-hidden">
                <thead class="bg-slate-700 text-slate-300">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Bulan</th>
                        <th class="px-4 py-2 text-left">Tahun</th>
                        <th class="px-4 py-2 text-left">Jumlah Gaji</th>
                        <th class="px-4 py-2 text-left">Gaji Lembur</th>
                        <th class="px-4 py-2 text-left">Potongan</th>
                        <th class="px-4 py-2 text-left">Gaji Diterima</th>
                        <th class="px-4 py-2 text-left">Tanggal Gaji</th>
                        @can('crud-data')
                            <th class="px-4 py-2 text-center">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse ($gaji as $p)
                        <tr class="hover:bg-slate-700/30">
                            <td class="px-4 py-2">{{ $p->pegawai->nama }}</td>
                            <td class="px-4 py-2">{{ $p->bulan }}</td>
                            <td class="px-4 py-2">{{ $p->tahun }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($p->jumlah_gaji, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($p->jumlah_lembur, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($p->potongan, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($p->gaji_diterima, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($p->tanggal_gaji)->format('d F Y') }}</td>

                            @can('crud-data')
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('gaji.edit', $p) }}"
                                        class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 rounded text-white text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('gaji.destroy', $p) }}" method="POST" class="inline">
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
                            <td colspan="9" class="px-4 py-3 text-center text-slate-400">
                                Belum ada data gaji
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection