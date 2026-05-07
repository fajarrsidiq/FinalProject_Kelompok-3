<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalCabang = Cabang::count();
        $totalBarang = Barang::count();
        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Transaksi::sum('total_bayar');
        $totalUser = User::count();
        $chartData = Transaksi::select(DB::raw('DATE(tanggal_transaksi) as tanggal'), DB::raw('SUM(total_bayar) as total'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->limit(7)
            ->get();
        $transaksiTerbaru = Transaksi::with(['cabang', 'kasir'])->latest()->limit(5)->get();

        return view('dashboard.index', compact('totalCabang', 'totalBarang', 'totalTransaksi', 'totalPendapatan', 'totalUser', 'chartData', 'transaksiTerbaru'));
    }
}