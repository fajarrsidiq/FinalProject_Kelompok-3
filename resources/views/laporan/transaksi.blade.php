@extends('components.layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Cetak Laporan Transaksi</h2>
    <form action="{{ route('laporan.transaksi.cetak') }}" method="POST" target="_blank">
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
            <label>Kasir</label>
            <select name="kasir_id" class="w-full border rounded px-3 py-2">
                <option value="">Semua Kasir</option>
                @foreach($kasirs as $kasir)
                    <option value="{{ $kasir->id }}">{{ $kasir->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-3 mb-3">
            <div>
                <label>Dari Tanggal</label>
                <input type="date" name="dari_tanggal" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label>Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" class="w-full border rounded px-3 py-2" required>
            </div>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Cetak PDF</button>
    </form>
</div>
@endsection 