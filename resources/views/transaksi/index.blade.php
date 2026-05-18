@extends('components.layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Riwayat Transaksi</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">No Invoice</th>
                    <th class="border px-4 py-2">Cabang</th>
                    <th class="border px-4 py-2">Kasir</th>
                    <th class="border px-4 py-2">Total</th>
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $trx)
                <tr>
                    <td class="border px-4 py-2">{{ $trx->no_invoice }}</td>
                    <td class="border px-4 py-2">{{ $trx->cabang->nama_toko ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $trx->kasir->nama_lengkap ?? '-' }}</td>
                    <td class="border px-4 py-2">Rp {{ number_format($trx->total_bayar,0,',','.') }}</td>
                    <td class="border px-4 py-2">{{ $trx->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('transaksi.invoice', $trx->id) }}" class="text-blue-600 hover:underline">Invoice</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $transaksis->links() }}
</div>
@endsection