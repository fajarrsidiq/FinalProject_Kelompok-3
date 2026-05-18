<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\StokMutasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $transaksis = Transaksi::with('cabang', 'kasir')
            ->when(!$user->isOwner(), fn($q) => $q->where('cabang_id', $user->cabang_id))
            ->latest()
            ->paginate(10);
        return view('transaksi.index', compact('transaksis'));
    }

    public function kasir()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $barangs = Barang::where('cabang_id', $user->cabang_id)
            ->where('stok', '>', 0)
            ->get();
        $cart = session()->get('cart', []);
        return view('transaksi.kasir', compact('barangs', 'cart'));
    }

    public function addToCart(Request $request)
    {
        $barang = Barang::findOrFail($request->barang_id);
        $cart = session()->get('cart', []);
        $qty = $request->qty;

        if (isset($cart[$barang->id])) {
            $cart[$barang->id]['qty'] += $qty;
        } else {
            $cart[$barang->id] = [
                'id' => $barang->id,
                'nama_barang' => $barang->nama_barang,
                'harga_jual' => $barang->harga_jual,
                'qty' => $qty,
                'subtotal' => $barang->harga_jual * $qty,
            ];
        }
        $cart[$barang->id]['subtotal'] = $cart[$barang->id]['harga_jual'] * $cart[$barang->id]['qty'];
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Barang ditambahkan ke keranjang.');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('transaksi.kasir')->with('error', 'Keranjang belanja kosong.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $totalBelanja = array_sum(array_column($cart, 'subtotal'));
        $diskon = 0;
        $totalBayar = $totalBelanja - $diskon;
        $tunai = $request->tunai;
        if ($tunai < $totalBayar) {
            return redirect()->back()->with('error', 'Uang tunai kurang dari total belanja.');
        }

        $noInvoice = 'INV/' . date('Ymd') . '/' . strtoupper(uniqid());

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'cabang_id' => $user->cabang_id,
                'kasir_id' => $user->id,
                'no_invoice' => $noInvoice,
                'total_belanja' => $totalBelanja,
                'diskon' => $diskon,
                'total_bayar' => $totalBayar,
                'tunai' => $tunai,
                'kembali' => $tunai - $totalBayar,
                'tanggal_transaksi' => now(),
                'status' => 'selesai',
            ]);

            foreach ($cart as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $item['id'],
                    'harga_jual' => $item['harga_jual'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal'],
                ]);

                $barang = Barang::find($item['id']);
                $barang->stok -= $item['qty'];
                $barang->save();

                StokMutasi::create([
                    'cabang_id' => $user->cabang_id,
                    'barang_id' => $item['id'],
                    'petugas_id' => $user->id,
                    'jenis' => 'keluar',
                    'qty' => $item['qty'],
                    'keterangan' => "Penjualan - $noInvoice",
                ]);
            }

            DB::commit();
            session()->forget('cart');
            return redirect()->route('transaksi.invoice', $transaksi->id)->with('success', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transaksi.kasir')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function invoice($id)
    {
        $transaksi = Transaksi::with(['cabang', 'kasir', 'details.barang'])->findOrFail($id);
        return view('transaksi.invoice', compact('transaksi'));
    }
}