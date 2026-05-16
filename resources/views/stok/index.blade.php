@extends('components.layouts.app')

@section('title', 'Cek Stok')

@section('content')
<div class="bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Daftar Stok Barang</h2>
    <div class="mb-3 flex gap-2">
        <input type="text" id="searchStok" placeholder="Cari barang..." class="border rounded px-3 py-2 w-full">
        <button onclick="filterStok()" class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Kode</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Kategori</th>
                    <th class="border px-4 py-2">Stok</th>
                    <th class="border px-4 py-2">Minimal</th>
                    <th class="border px-4 py-2">Satuan</th>
                    <th class="border px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody id="tabelStok">
                @foreach($barangs as $barang)
                <tr>
                    <td class="border px-4 py-2">{{ $barang->kode_barang }}</td>
                    <td class="border px-4 py-2">{{ $barang->nama_barang }}</td>
                    <td class="border px-4 py-2">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $barang->stok }}</td>
                    <td class="border px-4 py-2">{{ $barang->stok_minimal }}</td>
                    <td class="border px-4 py-2">{{ $barang->satuan }}</td>
                    <td class="border px-4 py-2">
                        @if($barang->stok <= 0)
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Habis</span>
                        @elseif($barang->stok <= $barang->stok_minimal)
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Menipis</span>
                        @else
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Tersedia</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $barangs->links() }}
</div>
<script>
    function filterStok() {
        let keyword = document.getElementById('searchStok').value.toLowerCase();
        let rows = document.querySelectorAll('#tabelStok tr');
        rows.forEach(row => {
            let nama = row.cells[1]?.innerText.toLowerCase();
            row.style.display = nama.includes(keyword) ? '' : 'none';
        });
    }
</script>
@endsection