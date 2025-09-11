@extends('layouts.app')

@section('title', 'Dashboard User')

@php $active = 'dashboard';
$title = 'Dashboard User'; @endphp

@section('content')
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="p-6 rounded-2xl glass shadow-md">
            <h3 class="text-lg font-semibold mb-2">Total Pegawai</h3>
            <p class="text-3xl font-bold text-accent">{{ $totalPegawai ?? 0 }}</p>
        </div>

        <div class="p-6 rounded-2xl glass shadow-md">
            <h3 class="text-lg font-semibold mb-2">Lembur Bulan Ini</h3>
            <p class="text-3xl font-bold text-accent">{{ $totalLembur ?? 0 }}</p>
        </div>

        <div class="p-6 rounded-2xl glass shadow-md">
            <h3 class="text-lg font-semibold mb-2">Total Gaji Dibayar Bulan Ini</h3>
            <p class="text-2xl font-bold text-accent">Rp {{ number_format($totalGaji ?? 0) }}</p>
        </div>
    </section>

    <!-- Grafik Tren -->
    <section class="p-6 rounded-2xl glass shadow-md">
        <h3 class="text-lg font-semibold mb-4">Statistik 6 Bulan Terakhir</h3>
        <canvas id="chartUser" height="120"></canvas>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxUser = document.getElementById('chartUser').getContext('2d');
        new Chart(ctxUser, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [
                    {
                        label: 'Total Gaji Dibayar',
                        data: @json($dataGaji),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Jumlah Lembur',
                        data: @json($dataLembur),
                        borderColor: '#06b6d4',
                        backgroundColor: 'rgba(6, 182, 212, 0.2)',
                        fill: true,
                        tension: 0.3
                    }
                ]
            }
        });
    </script>
@endsection