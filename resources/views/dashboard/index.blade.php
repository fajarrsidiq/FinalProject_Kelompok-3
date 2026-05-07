@extends('components.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->nama_lengkap ?? 'User' }}!</h2>
                <p class="text-blue-100 mt-1">Berikut ringkasan data toko Anda hari ini.</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                <i class="fas fa-chart-line text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 1 -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card Total Cabang -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 transition-all hover:shadow-lg card-hover">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Cabang</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalCabang ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-store text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-blue-50 px-5 py-2 text-xs text-blue-600">
                <i class="fas fa-building mr-1"></i> Seluruh cabang aktif
            </div>
        </div>

        <!-- Card Total Barang -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 transition-all hover:shadow-lg card-hover">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Barang</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalBarang ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-boxes text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 px-5 py-2 text-xs text-green-600">
                <i class="fas fa-box mr-1"></i> Jenis barang tersedia
            </div>
        </div>

        <!-- Card Total Transaksi -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 transition-all hover:shadow-lg card-hover">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Transaksi</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalTransaksi ?? 0 }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <i class="fas fa-receipt text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-yellow-50 px-5 py-2 text-xs text-yellow-600">
                <i class="fas fa-calendar-alt mr-1"></i> Sepanjang waktu
            </div>
        </div>

        <!-- Card Total Pendapatan -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 transition-all hover:shadow-lg card-hover">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Pendapatan</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-purple-50 px-5 py-2 text-xs text-purple-600">
                <i class="fas fa-rupiah-sign mr-1"></i> Total keseluruhan
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 2 (Widget mini) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-slate-50 to-white rounded-xl shadow p-4 border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-400 text-sm">Pesanan Baru</p>
                    <p class="text-2xl font-bold text-gray-800">27</p>
                </div>
                <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
            </div>
            <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up"></i> +12% dari kemarin</p>
        </div>
        <div class="bg-gradient-to-br from-slate-50 to-white rounded-xl shadow p-4 border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-400 text-sm">Bounce Rate</p>
                    <p class="text-2xl font-bold text-gray-800">53%</p>
                </div>
                <i class="fas fa-chart-simple text-gray-400 text-2xl"></i>
            </div>
            <p class="text-xs text-red-600 mt-2"><i class="fas fa-arrow-down"></i> -5% dari target</p>
        </div>
        <div class="bg-gradient-to-br from-slate-50 to-white rounded-xl shadow p-4 border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-400 text-sm">Registrasi User</p>
                    <p class="text-2xl font-bold text-gray-800">44</p>
                </div>
                <i class="fas fa-user-plus text-gray-400 text-2xl"></i>
            </div>
            <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up"></i> +8% bulan ini</p>
        </div>
        <div class="bg-gradient-to-br from-slate-50 to-white rounded-xl shadow p-4 border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-400 text-sm">Pengunjung Unik</p>
                    <p class="text-2xl font-bold text-gray-800">65</p>
                </div>
                <i class="fas fa-eye text-gray-400 text-2xl"></i>
            </div>
            <p class="text-xs text-blue-600 mt-2">Hari ini</p>
        </div>
    </div>

    <!-- Grafik Pendapatan dan Info Tambahan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grafik Pendapatan -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Grafik Pendapatan 7 Hari Terakhir</h3>
                <i class="fas fa-chart-line text-gray-400"></i>
            </div>
            <canvas id="revenueChart" height="200"></canvas>
        </div>

        <!-- Total User Card -->
        <div class="bg-gradient-to-br from-indigo-50 to-white rounded-2xl shadow-md p-6 border border-indigo-100">
            <div class="flex items-center gap-4">
                <div class="bg-indigo-100 rounded-full p-3">
                    <i class="fas fa-users text-indigo-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Pengguna</p>
                    <p class="text-3xl font-bold text-indigo-800">{{ $totalUser ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-indigo-100 text-sm text-gray-500">
                <i class="fas fa-user-check mr-1"></i> User aktif: {{ $totalUser ?? 0 }}
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi Terbaru (jika ada) -->
    @if(isset($transaksiTerbaru) && count($transaksiTerbaru) > 0)
    <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Transaksi Terbaru</h3>
            <a href="{{ route('transaksi.index') }}" class="text-blue-600 text-sm hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">No. Invoice</th>
                        <th class="px-4 py-2 text-left">Cabang</th>
                        <th class="px-4 py-2 text-left">Kasir</th>
                        <th class="px-4 py-2 text-right">Total</th>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksiTerbaru as $trx)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $trx->no_invoice }}</td>
                        <td class="px-4 py-2">{{ $trx->cabang->nama_toko ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $trx->kasir->nama_lengkap ?? '-' }}</td>
                        <td class="px-4 py-2 text-right">Rp {{ number_format($trx->total_bayar,0,',','.') }}</td>
                        <td class="px-4 py-2">{{ $trx->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Catatan Kaki -->
    <div class="text-center text-gray-400 text-xs pt-4">
        <i class="fas fa-database mr-1"></i> Data diperbarui secara real-time
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->pluck('tanggal')->map(fn($d) => date('d/m', strtotime($d)))) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartData->pluck('total')) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection