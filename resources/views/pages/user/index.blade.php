@extends('layouts.app')

@section('title', 'Data User')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-xl font-semibold">Daftar User</h2>

            <form action="{{ route('user.index') }}" method="GET" class="flex flex-wrap gap-2 items-center">
                <input type="text" name="search" placeholder="Cari nama / email" value="{{ request('search') }}"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200 focus:outline-none" />

                <select name="role" class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200">
                    <option value="">Semua Role</option>
                    @foreach($roles as $r)
                        <option value="{{ $r }}" @selected(request('role') == $r)>{{ $r }}</option>
                    @endforeach
                </select>

                <input type="date" name="created_from" value="{{ request('created_from') }}"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200" />
                <input type="date" name="created_to" value="{{ request('created_to') }}"
                    class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200" />

                <select name="per_page" class="px-3 py-2 rounded-lg bg-slate-700 text-slate-200">
                    @foreach([5, 10, 15, 25, 50] as $n)
                        <option value="{{ $n }}" @selected(request('per_page', 10) == $n)>{{ $n }} / halaman</option>
                    @endforeach
                </select>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-3 py-2 bg-blue-600 rounded-lg text-white">Terapkan</button>
                    <a href="{{ route('user.index') }}" class="px-3 py-2 bg-slate-600 rounded-lg text-white">Reset</a>

                    @can('crud-data')
                        <a href="{{ route('user.create') }}" class="px-4 py-2 bg-green-600 rounded-lg text-white">+ Tambah
                            User</a>
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
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Role</th>
                        @can('crud-data')
                            <th class="px-4 py-2 text-center">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse ($users as $p)
                        <tr class="hover:bg-slate-700/30">
                            {{-- nomor urut memperhitungkan pagination --}}
                            <td class="px-4 py-2">
                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                            </td>

                            <td class="px-4 py-2">{{ $p->name }}</td>
                            <td class="px-4 py-2">{{ $p->email }}</td>
                            <td class="px-4 py-2">{{ $p->role ?? '-' }}</td>

                            @can('crud-data')
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('user.edit', $p) }}"
                                        class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 rounded text-white text-sm">Edit</a>
                                    <form action="{{ route('user.destroy', $p) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="btn-delete px-2 py-1 bg-red-600 hover:bg-red-700 rounded text-white text-sm">Hapus</button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 4 + (Gate::allows('crud-data') ? 1 : 0) }}"
                                class="px-4 py-3 text-center text-slate-400">
                                Belum ada data User.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between text-sm text-slate-300">
            <div>
                Menampilkan {{ $users->firstItem() ? $users->firstItem() : 0 }}
                - {{ $users->lastItem() ? $users->lastItem() : 0 }} dari {{ $users->total() }} data
            </div>

            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection