@extends('components.layouts.app')

@section('title', 'Cabang')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Daftar Cabang</h2>
        <a href="{{ route('cabang.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">Tambah</a>
    </div>
    <table class="min-w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Nama Toko</th>
                <th class="border px-4 py-2">Alamat</th>
                <th class="border px-4 py-2">Kota</th>
                <th class="border px-4 py-2">Telepon</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cabangs as $cabang)
            <tr>
                <td class="border px-4 py-2">{{ $cabang->id }}</td>
                <td class="border px-4 py-2">{{ $cabang->nama_toko }}</td>
                <td class="border px-4 py-2">{{ $cabang->alamat }}</td>
                <td class="border px-4 py-2">{{ $cabang->kota }}</td>
                <td class="border px-4 py-2">{{ $cabang->telepon ?? '-' }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('cabang.edit', $cabang) }}" class="text-yellow-600">Edit</a>
                    <form action="{{ route('cabang.destroy', $cabang) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection