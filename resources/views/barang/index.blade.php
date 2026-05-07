@extends('components.layouts.app')

@section('title', 'Barang')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Daftar Barang</h2>
        <a href="{{ route('barang.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">+ Tambah</a>
    </div>
    <form method="GET" class="mb-4 flex gap-2">
        <input type="text" name="search" placeholder="Cari nama/kode..." class="border rounded px-3 py-2" value="{{ request('search') }}">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
    </form>
    <table class="min-w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">Kode</th>
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Kategori</th>
                <th class="border px-4 py-2">Harga Jual</th>
                <th class="border px-4 py-2">Stok</th>
                <th class="border px-4 py-2">Satuan</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $barang)
            <tr>
                <td class="border px-4 py-2">{{ $barang->kode_barang }}</td>
                <td class="border px-4 py-2">{{ $barang->nama_barang }}</td>
                <td class="border px-4 py-2">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                <td class="border px-4 py-2">Rp {{ number_format($barang->harga_jual,0,',','.') }}</td>
                <td class="border px-4 py-2">{{ $barang->stok }}</td>
                <td class="border px-4 py-2">{{ $barang->satuan }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('barang.edit', $barang) }}" class="text-yellow-600 hover:underline">Edit</a>
                    <form action="{{ route('barang.destroy', $barang) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $barangs->links() }}
</div>
@endsection