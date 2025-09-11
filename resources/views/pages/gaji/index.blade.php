@extends('layouts.app')

@section('title', 'Data Gaji')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-xl font-semibold">Daftar Gaji</h2>

            <form action="{{ route('gaji.index') }}" method="GET" class="flex flex-wrap gap-2 items-center">
                <input type="text" name="search" placeholder="Cari nama pegawai" value="{{ request('search') }}"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 focus:outline-none" />

                <select name="bulan" class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200">
                    <option value="">Semua Bulan</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" @selected((int) request('bulan') === $m)>{{ $m }}</option>
                    @endfor
                </select>

                <select name="tahun" class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200">
                    <option value="">Semua Tahun</option>
                    @foreach($years ?? [] as $y)
                        <option value="{{ $y }}" @selected(request('tahun') == $y)>{{ $y }}</option>
                    @endforeach
                </select>

                <input type="number" name="gaji_min" placeholder="Gaji min" value="{{ request('gaji_min') }}" min="0"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 w-32" />

                <input type="number" name="gaji_max" placeholder="Gaji max" value="{{ request('gaji_max') }}" min="0"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 w-32" />

                <input type="date" name="tanggal_from" value="{{ request('tanggal_from') }}"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200" />
                <input type="date" name="tanggal_to" value="{{ request('tanggal_to') }}"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200" />

                <select name="per_page" class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200">
                    @foreach([5, 10, 15, 25, 50] as $n)
                        <option value="{{ $n }}" @selected(request('per_page', 10) == $n)>{{ $n }} / halaman</option>
                    @endforeach
                </select>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-3 py-2 bg-blue-600 rounded-lg text-white">Terapkan</button>
                    <a href="{{ route('gaji.index') }}" class="px-3 py-2 bg-slate-600 rounded-lg text-white">Reset</a>

                    @can('crud-data')
                        <a href="{{ route('gaji.create') }}" class="px-4 py-2 bg-green-600 rounded-lg text-white">+ Tambah
                            Gaji</a>
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
                            {{-- nomor urut memperhitungkan pagination --}}
                            <td class="px-4 py-2">
                                {{ $loop->iteration + ($gaji->currentPage() - 1) * $gaji->perPage() }}
                            </td>

                            <td class="px-4 py-2">{{ $p->pegawai->nama ?? '-' }}</td>
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
                                    <form action="{{ route('gaji.destroy', $p) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus data gaji ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="btn-delete px-2 py-1 bg-red-600 hover:bg-red-700 rounded text-white text-sm">Hapus</button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 8 + (Gate::allows('crud-data') ? 1 : 0) }}"
                                class="px-4 py-3 text-center text-slate-400">
                                Belum ada data gaji.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between text-sm text-slate-300">
            <div>
                Menampilkan {{ $gaji->firstItem() ? $gaji->firstItem() : 0 }}
                - {{ $gaji->lastItem() ? $gaji->lastItem() : 0 }} dari {{ $gaji->total() }} data
            </div>

            <div>
                {{ $gaji->links() }}
            </div>
        </div>
    </div>
@endsection