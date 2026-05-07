<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Minishop') - Pak Jayusman</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { transform: translateX(4px); }
        .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.02); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header Glassmorphism -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-200/50">
            <div class="container mx-auto px-4 lg:px-6 py-3 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-2 rounded-xl shadow-md">
                        <i class="fas fa-store text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-800 to-indigo-800 bg-clip-text text-transparent">Minishop</h1>
                        <p class="text-xs text-gray-500 -mt-0.5">Pak Jayusman</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <div class="hidden md:flex items-center gap-2 bg-gray-100 px-3 py-1.5 rounded-full">
                            <i class="fas fa-user-circle text-blue-600 text-lg"></i>
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->nama_lengkap ?? 'User' }}</span>
                            <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 bg-red-500/90 hover:bg-red-600 text-white px-3 py-1.5 rounded-full text-sm transition shadow-md">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </header>

        <div class="flex flex-1">
            <!-- Sidebar Modern -->
            <aside class="w-72 lg:w-80 bg-white/70 backdrop-blur-sm shadow-xl border-r border-gray-200/60 flex-shrink-0 overflow-y-auto">
                <nav class="p-5 space-y-1">
                    <div class="mb-6 pb-2 border-b border-gray-200">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Navigasi Utama</p>
                    </div>

                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-tachometer-alt w-5 text-lg"></i>
                        <span>Dashboard</span>
                        @if(request()->routeIs('dashboard'))
                            <i class="fas fa-chevron-right ml-auto text-xs"></i>
                        @endif
                    </a>

                    @auth
                        <!-- Master Data -->
                        @if(Auth::user()->isOwner() || Auth::user()->isManager())
                            <div class="pt-4 mt-4 border-t border-gray-200">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mb-2">Master Data</p>
                            </div>
                            <a href="{{ route('cabang.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('cabang.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-building w-5"></i><span>Cabang</span>
                            </a>
                            <a href="{{ route('kategori.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('kategori.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-tags w-5"></i><span>Kategori</span>
                            </a>
                            <a href="{{ route('barang.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('barang.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-boxes w-5"></i><span>Barang</span>
                            </a>
                            <a href="{{ route('pegawai.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('pegawai.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-users w-5"></i><span>Pegawai</span>
                            </a>
                        @endif

                        <!-- Transaksi -->
                        @if(Auth::user()->isKasir() || Auth::user()->isSupervisor() || Auth::user()->isManager() || Auth::user()->isOwner())
                            <div class="pt-4 mt-4 border-t border-gray-200">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mb-2">Transaksi</p>
                            </div>
                            <a href="{{ route('transaksi.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('transaksi.index') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-history w-5"></i><span>Riwayat Transaksi</span>
                            </a>
                            <a href="{{ route('transaksi.kasir') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('transaksi.kasir') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-cash-register w-5"></i><span>Kasir (POS)</span>
                            </a>
                        @endif

                        <!-- Stok -->
                        @if(Auth::user()->isGudang() || Auth::user()->isManager() || Auth::user()->isOwner())
                            <div class="pt-4 mt-4 border-t border-gray-200">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mb-2">Manajemen Stok</p>
                            </div>
                            <a href="{{ route('stok.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('stok.index') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-warehouse w-5"></i><span>Cek Stok</span>
                            </a>
                            <a href="{{ route('stok.mutasi') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('stok.mutasi') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-exchange-alt w-5"></i><span>Mutasi Stok</span>
                            </a>
                        @endif

                        <!-- Laporan -->
                        @if(Auth::user()->isOwner() || Auth::user()->isManager())
                            <div class="pt-4 mt-4 border-t border-gray-200">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mb-2">Laporan</p>
                            </div>
                            <a href="{{ route('laporan.transaksi') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('laporan.transaksi') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-file-invoice w-5"></i><span>Laporan Transaksi</span>
                            </a>
                            <a href="{{ route('laporan.stok') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('laporan.stok') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-file-alt w-5"></i><span>Laporan Stok</span>
                            </a>
                        @endif
                    @endauth
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-4 lg:p-8 overflow-y-auto">
                <div class="max-w-7xl mx-auto">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-lg shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button onclick="this.parentElement.style.display='none'" class="text-green-700 hover:text-green-900">&times;</button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-lg shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                            <button onclick="this.parentElement.style.display='none'" class="text-red-700 hover:text-red-900">&times;</button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white/70 backdrop-blur-sm border-t border-gray-200/60 py-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} <span class="font-semibold text-indigo-600">Minishop</span> - Sistem Informasi Manajemen Mini Market Pak Jayusman
        </footer>
    </div>

    @stack('scripts')
</body>
</html>