@extends('layouts.app')

@section('title', 'Data Golongan')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-xl font-semibold">Daftar Golongan</h2>

            <form action="{{ route('golongan.index') }}" method="GET" class="flex flex-wrap gap-2 items-center">
                <input type="text" name="search" placeholder="Cari nama golongan" value="{{ request('search') }}"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 focus:outline-none" />

                <input type="number" name="gaji_min" placeholder="Gaji min" value="{{ request('gaji_min') }}" min="0"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 w-28" />

                <input type="number" name="gaji_max" placeholder="Gaji max" value="{{ request('gaji_max') }}" min="0"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 w-28" />

                <select name="per_page" class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200">
                    @foreach([5, 10, 15, 25, 50] as $n)
                        <option value="{{ $n }}" @selected(request('per_page', 10) == $n)>{{ $n }} / halaman</option>
                    @endforeach
                </select>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-3 py-2 bg-blue-600 rounded-lg text-white">Terapkan</button>
                    <a href="{{ route('golongan.index') }}" class="px-3 py-2 bg-slate-600 rounded-lg text-white">Reset</a>

                    @can('crud-data')
                        <a href="{{ route('golongan.create') }}" class="px-4 py-2 bg-green-600 rounded-lg text-white">+ Tambah
                            Golongan</a>
                    @endcan
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-700 rounded-lg overflow-hidden">
                <thead class="bg-slate-700 text-slate-300">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
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
                            {{-- nomor urut memperhitungkan pagination --}}
                            <td class="px-4 py-2">
                                {{ $loop->iteration + ($golongan->currentPage() - 1) * $golongan->perPage() }}
                            </td>

                            <td class="px-4 py-2">{{ $p->nama }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($p->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($p->tunjangan_keluarga, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($p->tunjangan_transport, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($p->tunjangan_makan, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($p->tarif_lembur_per_jam, 0, ',', '.') }}</td>

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
                            <td colspan="{{ 7 + (Gate::allows('crud-data') ? 1 : 0) }}"
                                class="px-4 py-3 text-center text-slate-400">
                                Belum ada data golongan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between text-sm text-slate-300">
            <div>
                Menampilkan {{ $golongan->firstItem() ? $golongan->firstItem() : 0 }}
                - {{ $golongan->lastItem() ? $golongan->lastItem() : 0 }} dari {{ $golongan->total() }} data
            </div>

            <div>
                {{ $golongan->links() }}
            </div>
        </div>
    </div>
@endsection