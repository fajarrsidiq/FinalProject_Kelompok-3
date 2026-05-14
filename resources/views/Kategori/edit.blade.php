@extends('components.layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit Kategori</h2>
    <form action="{{ route('kategori.update', $kategori) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="block font-medium mb-1">Nama Kategori</label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full border rounded px-3 py-2">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
        </div>
        <div class="flex justify-end gap-2">
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('kategori.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection