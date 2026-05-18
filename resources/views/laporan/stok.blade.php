@extends('components.layouts.app')

@section('title', 'Laporan Stok')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Cetak Laporan Stok</h2>
    <form action="{{ route('laporan.stok.cetak') }}" method="POST" target="_blank">
        @csrf
        @if(Auth::user()->isOwner())
        <div class="mb-3">
            <label>Cabang</label>
            <select name="cabang_id" class="w-full border rounded px-3 py-2">
                <option value="">Semua Cabang</option>
                @foreach($cabangs as $cabang)
                    <option value="{{ $cabang->id }}">{{ $cabang->nama_toko }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori_id" class="w-full border rounded px-3 py-2">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Status Stok</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="">Semua</option>
                <option value="tersedia">Tersedia</option>
                <option value="menipis">Menipis</option>
                <option value="habis">Habis</option>
            </select>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Cetak PDF</button>
    </form>
</div>
@endsection