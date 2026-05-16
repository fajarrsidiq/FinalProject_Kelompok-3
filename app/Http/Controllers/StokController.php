<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokMutasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $query = Barang::with('kategori');
        if (!$user->isOwner()) {
            $query->where('cabang_id', $user->cabang_id);
        }
        $barangs = $query->orderBy('stok', 'asc')->paginate(15);
        return view('stok.index', compact('barangs'));
    }

    public function mutasi()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $mutasis = StokMutasi::with('barang', 'petugas')
            ->when(!$user->isOwner(), fn($q) => $q->where('cabang_id', $user->cabang_id))
            ->latest()
            ->paginate(15);
        $barangs = Barang::when(!$user->isOwner(), fn($q) => $q->where('cabang_id', $user->cabang_id))->get();
        return view('stok.mutasi', compact('mutasis', 'barangs'));
    }

    public function storeMutasi(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jenis' => 'required|in:masuk,keluar',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jenis === 'keluar' && $barang->stok < $request->qty) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        DB::beginTransaction();
        try {
            if ($request->jenis === 'masuk') {
                $barang->stok += $request->qty;
            } else {
                $barang->stok -= $request->qty;
            }
            $barang->save();

            StokMutasi::create([
                'cabang_id' => $user->cabang_id,
                'barang_id' => $request->barang_id,
                'petugas_id' => $user->id,
                'jenis' => $request->jenis,
                'qty' => $request->qty,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();
            return redirect()->route('stok.mutasi')->with('success', 'Mutasi stok berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan mutasi: ' . $e->getMessage());
        }
    }
}
