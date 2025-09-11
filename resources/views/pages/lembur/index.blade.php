@extends('layouts.app')

@section('title', 'Data Lembur')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-xl font-semibold">Daftar Lembur</h2>

            <form action="{{ route('lembur.index') }}" method="GET" class="flex flex-wrap gap-2 items-center">
                <input type="text" name="search" placeholder="Cari nama pegawai" value="{{ request('search') }}"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 focus:outline-none" />

                <select name="bulan" class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200">
                    <option value="">Semua Bulan</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" @selected((int) request('bulan') === $m)>{{ $m }}</option>
                    @endfor
                </select>

                <input type="number" name="tahun" placeholder="Tahun" value="{{ request('tahun') }}" min="2000"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 w-24" />

                <input type="number" name="rate_min" placeholder="Rate min" value="{{ request('rate_min') }}" min="0"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 w-28" />

                <input type="number" name="rate_max" placeholder="Rate max" value="{{ request('rate_max') }}" min="0"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 w-28" />

                <select name="per_page" class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200">
                    @foreach([5, 10, 15, 25, 50] as $n)
                        <option value="{{ $n }}" @selected(request('per_page', 10) == $n)>{{ $n }} / halaman</option>
                    @endforeach
                </select>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-3 py-2 bg-blue-600 rounded-lg text-white">Terapkan</button>
                    <a href="{{ route('lembur.index') }}" class="px-3 py-2 bg-slate-600 rounded-lg text-white">Reset</a>

                    @can('crud-data')
                        <a href="{{ route('lembur.create') }}" class="px-4 py-2 bg-green-600 rounded-lg text-white">+ Tambah
                            Lembur</a>
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
                        <th class="px-4 py-2 text-left">Bulan</th>
                        <th class="px-4 py-2 text-left">Tahun</th>
                        <th class="px-4 py-2 text-left">Jumlah Jam</th>
                        <th class="px-4 py-2 text-left">Rate /Jam</th>
                        @can('crud-data')
                            <th class="px-4 py-2 text-center">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse ($lembur as $p)
                        <tr class="hover:bg-slate-700/30">
                            {{-- nomor urut memperhitungkan pagination --}}
                            <td class="px-4 py-2">
                                {{ $loop->iteration + ($lembur->currentPage() - 1) * $lembur->perPage() }}
                            </td>

                            <td class="px-4 py-2">{{ $p->pegawai->nama ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $p->bulan }}</td>
                            <td class="px-4 py-2">{{ $p->tahun }}</td>
                            <td class="px-4 py-2">{{ $p->jumlah_jam ?? '-' }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($p->rate_per_jam, 0, ',', '.') }}</td>

                            @can('crud-data')
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('lembur.edit', $p) }}"
                                        class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 rounded text-white text-sm">Edit</a>
                                    <form action="{{ route('lembur.destroy', $p) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus data lembur ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="btn-delete px-2 py-1 bg-red-600 hover:bg-red-700 rounded text-white text-sm">Hapus</button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 6 + (Gate::allows('crud-data') ? 1 : 0) }}"
                                class="px-4 py-3 text-center text-slate-400">
                                Belum ada data Lembur.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between text-sm text-slate-300">
            <div>
                Menampilkan {{ $lembur->firstItem() ? $lembur->firstItem() : 0 }}
                - {{ $lembur->lastItem() ? $lembur->lastItem() : 0 }} dari {{ $lembur->total() }} data
            </div>

            <div>
                {{ $lembur->links() }}
            </div>
        </div>
    </div>
@endsection