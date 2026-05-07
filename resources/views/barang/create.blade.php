@extends('components.layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Tambah Barang Baru</h2>
    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="block font-medium mb-1">Kode Barang</label>
            <input type="text" name="kode_barang" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Nama Barang</label>
            <input type="text" name="nama_barang" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Kategori</label>
            <select name="kategori_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Harga Beli</label>
            <input type="number" name="harga_beli" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Harga Jual</label>
            <input type="number" name="harga_jual" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Stok Awal</label>
            <input type="number" name="stok" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Stok Minimal</label>
            <input type="number" name="stok_minimal" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Satuan</label>
            <input type="text" name="satuan" class="w-full border rounded px-3 py-2" required value="pcs">
        </div>
        @if(Auth::user()->isOwner())
        <div class="mb-3">
            <label class="block font-medium mb-1">Cabang</label>
            <select name="cabang_id" class="w-full border rounded px-3 py-2" required>
                @foreach($cabangs as $cabang)
                    <option value="{{ $cabang->id }}">{{ $cabang->nama_toko }}</option>
                @endforeach
            </select>
        </div>
        @else
            <input type="hidden" name="cabang_id" value="{{ Auth::user()->cabang_id }}">
        @endif
        <div class="flex justify-end gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('barang.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection