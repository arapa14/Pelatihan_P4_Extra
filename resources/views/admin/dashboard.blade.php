@extends('layouts.app')

@section('title', 'Dashboard')

@php 
            $active = 'dashboard';
    $title = 'Dashboard'; 
@endphp

@section('content')
    <!-- Statistik ringkas -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="p-6 rounded-2xl glass shadow-md">
            <h3 class="text-lg font-semibold mb-2">Total Pegawai</h3>
            <p class="text-3xl font-bold text-accent">{{ $totalPegawai ?? 0 }}</p>
        </div>

        <div class="p-6 rounded-2xl glass shadow-md">
            <h3 class="text-lg font-semibold mb-2">Total User</h3>
            <p class="text-3xl font-bold text-accent">{{ $totalUser ?? 0 }}</p>
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

    <!-- Grafik Analitik -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="p-6 rounded-2xl glass shadow-md">
            <h3 class="text-lg font-semibold mb-4">Trend Gaji 6 Bulan Terakhir</h3>
            <canvas id="chartGaji"></canvas>
        </div>

        <div class="p-6 rounded-2xl glass shadow-md">
            <h3 class="text-lg font-semibold mb-4">Trend Lembur 6 Bulan Terakhir</h3>
            <canvas id="chartLembur"></canvas>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labels);
        const dataGaji = @json($dataGaji);
        const dataLembur = @json($dataLembur);

        // Grafik Gaji
        new Chart(document.getElementById('chartGaji'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Gaji',
                    data: dataGaji,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.3,
                    fill: true,
                }]
            }
        });

        // Grafik Lembur
        new Chart(document.getElementById('chartLembur'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Lembur',
                    data: dataLembur,
                    backgroundColor: '#06b6d4',
                }]
            }
        });
    </script>
@endpush