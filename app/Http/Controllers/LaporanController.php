<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function transaksi()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cabangs = $user->isOwner() ? Cabang::all() : collect([$user->cabang]);
        $kasirs = $user->isOwner() ? User::where('role', 'kasir')->get() : User::where('cabang_id', $user->cabang_id)->where('role', 'kasir')->get();
        return view('laporan.transaksi', compact('cabangs', 'kasirs'));
    }

    public function cetakTransaksi(Request $request)
    {
        $request->validate([
            'dari_tanggal' => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $query = Transaksi::with('cabang', 'kasir');
        if (!$user->isOwner()) {
            $query->where('cabang_id', $user->cabang_id);
        }
        if ($request->filled('cabang_id') && $user->isOwner()) {
            $query->where('cabang_id', $request->cabang_id);
        }
        if ($request->filled('kasir_id')) {
            $query->where('kasir_id', $request->kasir_id);
        }
        $query->whereDate('tanggal_transaksi', '>=', $request->dari_tanggal)
              ->whereDate('tanggal_transaksi', '<=', $request->sampai_tanggal);
        $transaksis = $query->orderBy('tanggal_transaksi')->get();
        $totalPendapatan = $transaksis->sum('total_bayar');
        $totalTransaksi = $transaksis->count();

        $pdf = Pdf::loadView('laporan.pdf.transaksi', compact('transaksis', 'totalPendapatan', 'totalTransaksi', 'request'));
        return $pdf->download('laporan_transaksi_' . date('Ymd_His') . '.pdf');
    }

    public function stok()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cabangs = $user->isOwner() ? Cabang::all() : collect([$user->cabang]);
        $kategoris = KategoriBarang::all();
        return view('laporan.stok', compact('cabangs', 'kategoris'));
    }

    public function cetakStok(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $query = Barang::with('cabang', 'kategori');
        if (!$user->isOwner()) {
            $query->where('cabang_id', $user->cabang_id);
        }
        if ($request->filled('cabang_id') && $user->isOwner()) {
            $query->where('cabang_id', $request->cabang_id);
        }
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('status')) {
            if ($request->status === 'menipis') $query->whereRaw('stok <= stok_minimal');
            elseif ($request->status === 'habis') $query->where('stok', '=', 0);
        }
        $barangs = $query->orderBy('nama_barang')->get();

        $pdf = Pdf::loadView('laporan.pdf.stok', compact('barangs', 'request'));
        return $pdf->download('laporan_stok_' . date('Ymd_His') . '.pdf');
    }
}