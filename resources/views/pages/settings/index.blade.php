@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('content')
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg max-w-3xl mx-auto">
        <h2 class="text-xl font-semibold mb-6">Pengaturan Aplikasi</h2>

        @if(session('success'))
            <div class="bg-green-600 text-white p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-600 text-white p-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Nama Aplikasi -->
            <div>
                <label class="block text-slate-300 mb-1">Nama Aplikasi</label>
                <input type="text" name="app_name" value="{{ old('app_name', $settings['app_name'] ?? '') }}"
                    class="w-full rounded-lg px-3 py-2 bg-slate-700 text-slate-300 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('app_name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo Aplikasi -->
            <div>
                <label class="block text-slate-300 mb-1">Logo Aplikasi</label>
                <input type="file" name="app_logo" id="logoInput" class="w-full text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                           file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700" />

                @error('app_logo')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div class="mt-3">
                    <p class="text-slate-400 text-sm">Preview:</p>
                    <img id="logoPreview"
                        src="{{ isset($settings['app_logo']) ? asset($settings['app_logo']) : '' }}"
                        alt="Preview Logo" class="mt-2 w-20 h-20 object-cover rounded-md border border-slate-600">
                </div>
            </div>

            <button type="submit"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-medium transition">
                Simpan Perubahan
            </button>
        </form>
    </div>

    <script>
        // Preview gambar sebelum upload
        document.getElementById('logoInput').addEventListener('change', function (event) {
            const reader = new FileReader();
            reader.onload = function () {
                document.getElementById('logoPreview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
@endsection