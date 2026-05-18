@extends('components.layouts.app')

@section('title', 'Invoice')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-3xl mx-auto">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold">MINISHOP</h2>
        <p>{{ $transaksi->cabang->nama_toko ?? 'Pak Jayusman' }}</p>
        <p>{{ $transaksi->cabang->alamat ?? '' }}</p>
    </div>
    <div class="flex justify-between border-b pb-2 mb-4">
        <span>No Invoice: <strong>{{ $transaksi->no_invoice }}</strong></span>
        <span>Tanggal: {{ $transaksi->tanggal_transaksi->format('d/m/Y H:i:s') }}</span>
    </div>
    <div class="mb-4">
        <p>Kasir: {{ $transaksi->kasir->nama_lengkap ?? '-' }}</p>
    </div>
    <table class="w-full border mb-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Barang</th>
                <th class="border px-2 py-1">Qty</th>
                <th class="border px-2 py-1">Harga</th>
                <th class="border px-2 py-1">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $detail)
            <tr>
                <td class="border px-2 py-1">{{ $detail->barang->nama_barang }}</td>
                <td class="border px-2 py-1 text-center">{{ $detail->qty }}</td>
                <td class="border px-2 py-1 text-right">Rp {{ number_format($detail->harga_jual,0,',','.') }}</td>
                <td class="border px-2 py-1 text-right">Rp {{ number_format($detail->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="border-t"><td colspan="3" class="text-right font-bold">Total:</td><td class="text-right">Rp {{ number_format($transaksi->total_bayar,0,',','.') }}</td></tr>
            <tr><td colspan="3" class="text-right">Tunai:</td><td class="text-right">Rp {{ number_format($transaksi->tunai,0,',','.') }}</td></tr>
            <tr><td colspan="3" class="text-right">Kembali:</td><td class="text-right">Rp {{ number_format($transaksi->kembali,0,',','.') }}</td></tr>
        </tfoot>
    </table>
    <div class="text-center">
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded">Cetak</button>
        <a href="{{ route('transaksi.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded ml-2">Kembali</a>
    </div>
</div>
@endsection