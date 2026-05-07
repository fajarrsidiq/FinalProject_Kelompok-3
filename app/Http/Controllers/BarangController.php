<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->paginate(10);
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $kategoris = KategoriBarang::all();
        $cabangs = $user->isOwner() ? Cabang::all() : collect();
        return view('barang.create', compact('kategoris', 'cabangs'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode_barang' => 'required|unique:barang',
                'nama_barang' => 'required',
                'kategori_id' => 'required|exists:kategori_barang,id',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0|gt:harga_beli',
                'stok' => 'required|integer|min:0',
                'stok_minimal' => 'required|integer|min:0',
                'satuan' => 'required|string|max:20'
            ]);

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Jika owner, wajib pilih cabang
            if ($user->isOwner()) {
                $request->validate([
                    'cabang_id' => 'required|exists:cabang_toko,id'
                ]);
                $data = $request->all();
            } else {
                // Non-owner: ambil dari user
                if (!$user->cabang_id) {
                    return back()->withInput()->with('error', 'Akun Anda tidak terhubung ke cabang mana pun. Hubungi administrator.');
                }
                $data = $request->all();
                $data['cabang_id'] = $user->cabang_id;
            }

            Barang::create($data);
            return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Tangkap error database
            if ($e->errorInfo[1] == 1452) {
                return back()->withInput()->with('error', 'Cabang tidak valid. Pastikan Anda memilih cabang yang benar.');
            }
            if ($e->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', 'Kode barang sudah digunakan. Gunakan kode lain.');
            }
            return back()->withInput()->with('error', 'Database error: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Barang $barang)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $kategoris = KategoriBarang::all();
        $cabangs = $user->isOwner() ? Cabang::all() : collect();
        return view('barang.edit', compact('barang', 'kategoris', 'cabangs'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang,' . $barang->id,
            'nama_barang' => 'required',
            'kategori_id' => 'required|exists:kategori_barang,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gt:harga_beli',
            'stok' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20'
        ]);

        $barang->update($request->all());
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}