@extends('components.layouts.app')

@section('title', 'Kasir POS')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Pilih Barang (kolom kiri) -->
        <div class="bg-white rounded-xl shadow-md p-5">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">📦 Pilih Barang</h2>
            <form action="{{ route('transaksi.cart.add') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
                    <select name="barang_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}">
                            {{ $barang->nama_barang }} - Rp {{ number_format($barang->harga_jual,0,',','.') }} (Stok: {{ $barang->stok }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" name="qty" value="1" min="1" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                    <i class="fas fa-cart-plus mr-2"></i> Tambah ke Keranjang
                </button>
            </form>
        </div>

        <!-- Tabel Keranjang (kolom kanan) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-5">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">🛒 Keranjang Belanja</h2>
            <div class="overflow-x-auto mb-4">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left">Barang</th>
                            <th class="px-3 py-2 text-center">Qty</th>
                            <th class="px-3 py-2 text-right">Subtotal</th>
                            <th class="px-3 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cart as $id => $item)
                        <tr class="border-b">
                            <td class="px-3 py-2">{{ $item['nama_barang'] }}</td>
                            <td class="px-3 py-2 text-center">{{ $item['qty'] }}</td>
                            <td class="px-3 py-2 text-right">Rp {{ number_format($item['subtotal'],0,',','.') }}</td>
                            <td class="px-3 py-2 text-center">
                                <a href="{{ route('transaksi.cart.remove', $id) }}" class="text-red-500 hover:text-red-700" onclick="return confirm('Hapus item ini?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">Keranjang kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t pt-4">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-bold text-gray-800">Total:</span>
                    <span class="text-2xl font-bold text-green-600">
                        Rp {{ number_format(array_sum(array_column($cart, 'subtotal')),0,',','.') }}
                    </span>
                </div>
                <form action="{{ route('transaksi.checkout') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tunai</label>
                        <input type="number" name="tunai" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-lg transition duration-200">
                        <i class="fas fa-check mr-2"></i> Bayar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection