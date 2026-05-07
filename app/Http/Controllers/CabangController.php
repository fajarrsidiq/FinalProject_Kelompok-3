<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index()
    {
        $cabangs = Cabang::all();
        return view('cabang.index', compact('cabangs'));
    }

    public function create()
    {
        return view('cabang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:50',
            'telepon' => 'nullable|string|max:20',
        ]);
        Cabang::create($request->all());
        return redirect()->route('cabang.index')->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function edit(Cabang $cabang)
    {
        return view('cabang.edit', compact('cabang'));
    }

    public function update(Request $request, Cabang $cabang)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:50',
            'telepon' => 'nullable|string|max:20',
        ]);
        $cabang->update($request->all());
        return redirect()->route('cabang.index')->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Cabang $cabang)
    {
        $cabang->delete();
        return redirect()->route('cabang.index')->with('success', 'Cabang berhasil dihapus.');
    }
}