@extends('components.layouts.app')

@section('title', 'Mutasi Stok')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Form Mutasi -->
    <div class="bg-white rounded shadow p-4">
        <h2 class="text-xl font-bold mb-4">Tambah Mutasi Stok</h2>
        <form action="{{ route('stok.mutasi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Barang</label>
                <select name="barang_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }} (Stok: {{ $barang->stok }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Jenis Mutasi</label>
                <select name="jenis" class="w-full border rounded px-3 py-2" required>
                    <option value="masuk">Barang Masuk</option>
                    <option value="keluar">Barang Keluar</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="qty" class="w-full border rounded px-3 py-2" required min="1">
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" rows="2" class="w-full border rounded px-3 py-2"></textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Mutasi</button>
        </form>
    </div>

    <!-- Riwayat Mutasi -->
    <div class="bg-white rounded shadow p-4">
        <h2 class="text-xl font-bold mb-4">Riwayat Mutasi</h2>
        <div class="overflow-y-auto max-h-96">
            <table class="min-w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">Tanggal</th>
                        <th class="border px-2 py-1">Barang</th>
                        <th class="border px-2 py-1">Jenis</th>
                        <th class="border px-2 py-1">Jumlah</th>
                        <th class="border px-2 py-1">Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mutasis as $mutasi)
                    <tr>
                        <td class="border px-2 py-1">{{ $mutasi->created_at->format('d/m/Y H:i') }}</td>
                        <td class="border px-2 py-1">{{ $mutasi->barang->nama_barang }}</td>
                        <td class="border px-2 py-1">{{ $mutasi->jenis == 'masuk' ? 'Masuk' : 'Keluar' }}</td>
                        <td class="border px-2 py-1">{{ $mutasi->qty }}</td>
                        <td class="border px-2 py-1">{{ $mutasi->petugas->nama_lengkap ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $mutasis->links() }}
    </div>
</div>
@endsection