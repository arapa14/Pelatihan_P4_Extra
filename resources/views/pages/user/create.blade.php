@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg max-w-lg mx-auto">
        <h2 class="text-xl font-semibold mb-6">Tambah User</h2>

        <form action="{{ route('user.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-slate-300 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full rounded-lg px-3 py-2 bg-slate-700 text-slate-300 focus:outline-none focus:ring" required>
            </div>

            <div>
                <label class="block text-slate-300 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full rounded-lg px-3 py-2 bg-slate-700 text-slate-300 focus:outline-none focus:ring" required>
            </div>

            <div>
                <label class="block text-slate-300 mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full rounded-lg px-3 py-2 bg-slate-700 text-slate-300 focus:outline-none focus:ring" required>
            </div>

            <div>
                <label class="block text-slate-300 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full rounded-lg px-3 py-2 bg-slate-700 text-slate-300 focus:outline-none focus:ring" required>
            </div>

            <div>
                <label class="block text-slate-300 mb-1">Role</label>
                <select name="role"
                    class="w-full rounded-lg px-3 py-2 bg-slate-700 text-slate-300 focus:outline-none focus:ring" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white shadow">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection