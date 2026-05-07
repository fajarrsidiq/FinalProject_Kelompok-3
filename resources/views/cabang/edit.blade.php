@extends('components.layouts.app')

@section('title', 'Edit Cabang')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit Cabang</h2>
    <form action="{{ route('cabang.update', $cabang) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="block font-medium">Nama Toko</label>
            <input type="text" name="nama_toko" value="{{ old('nama_toko', $cabang->nama_toko) }}" class="border rounded w-full p-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium">Alamat</label>
            <textarea name="alamat" rows="3" class="border rounded w-full p-2" required>{{ old('alamat', $cabang->alamat) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="block font-medium">Kota</label>
            <input type="text" name="kota" value="{{ old('kota', $cabang->kota) }}" class="border rounded w-full p-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium">Telepon</label>
            <input type="text" name="telepon" value="{{ old('telepon', $cabang->telepon) }}" class="border rounded w-full p-2">
        </div>
        <div class="flex justify-end gap-2">
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('cabang.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection