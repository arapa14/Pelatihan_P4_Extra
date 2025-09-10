@extends('layouts.app')

@section('title', 'Dashboard')

@php $active = 'dashboard';
$title = 'Dashboard'; @endphp

@section('content')
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="p-6 rounded-2xl glass shadow-md">
            <h3 class="text-lg font-semibold mb-2">Total Pegawai</h3>
            <p class="text-3xl font-bold text-accent">{{ $totalPegawai ?? 0 }}</p>
        </div>

        <div class="p-6 rounded-2xl glass shadow-md">
            <h3 class="text-lg font-semibold mb-2">Lembur Bulan Ini</h3>
            <p class="text-3xl font-bold text-accent">{{ $totalLembur ?? 0 }}</p>
        </div>

        <div class="p-6 rounded-2xl glass shadow-md">
            <h3 class="text-lg font-semibold mb-2">Total Gaji Dibayar</h3>
            <p class="text-3xl font-bold text-accent">Rp {{ number_format($totalGaji ?? 0) }}</p>
        </div>
    </section>
@endsection