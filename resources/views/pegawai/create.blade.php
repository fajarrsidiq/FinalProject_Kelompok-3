@extends('components.layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Tambah Pegawai Baru</h2>
    <form action="{{ route('pegawai.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="block font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Role</label>
            <select name="role" class="w-full border rounded px-3 py-2" required>
                <option value="kasir">Kasir</option>
                <option value="gudang">Gudang</option>
                <option value="supervisor">Supervisor</option>
                <option value="manager">Manager</option>
            </select>
        </div>
        @if(Auth::user()->isOwner())
        <div class="mb-3">
            <label class="block font-medium mb-1">Cabang</label>
            <select name="cabang_id" class="w-full border rounded px-3 py-2" required>
                @foreach($cabangs as $cabang)
                    <option value="{{ $cabang->id }}">{{ $cabang->nama_toko }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="flex justify-end gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('pegawai.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection