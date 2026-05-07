@extends('components.layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit Barang</h2>
    <form action="{{ route('barang.update', $barang) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="block font-medium mb-1">Kode Barang</label>
            <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Nama Barang</label>
            <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Kategori</label>
            <select name="kategori_id" class="w-full border rounded px-3 py-2" required>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ $barang->kategori_id == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Harga Beli</label>
            <input type="number" name="harga_beli" value="{{ old('harga_beli', $barang->harga_beli) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Harga Jual</label>
            <input type="number" name="harga_jual" value="{{ old('harga_jual', $barang->harga_jual) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Stok</label>
            <input type="number" name="stok" value="{{ old('stok', $barang->stok) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Stok Minimal</label>
            <input type="number" name="stok_minimal" value="{{ old('stok_minimal', $barang->stok_minimal) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Satuan</label>
            <input type="text" name="satuan" value="{{ old('satuan', $barang->satuan) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        @if(Auth::user()->isOwner())
        <div class="mb-3">
            <label class="block font-medium mb-1">Cabang</label>
            <select name="cabang_id" class="w-full border rounded px-3 py-2" required>
                @foreach($cabangs as $cabang)
                    <option value="{{ $cabang->id }}" {{ $barang->cabang_id == $cabang->id ? 'selected' : '' }}>{{ $cabang->nama_toko }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="flex justify-end gap-2">
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('barang.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection