@extends('components.layouts.app')

@section('title', 'Edit Pegawai')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit Pegawai</h2>
    <form action="{{ route('pegawai.update', $pegawai) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="block font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $pegawai->email) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Role</label>
            <select name="role" class="w-full border rounded px-3 py-2" required>
                <option value="kasir" {{ $pegawai->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                <option value="gudang" {{ $pegawai->role == 'gudang' ? 'selected' : '' }}>Gudang</option>
                <option value="supervisor" {{ $pegawai->role == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                <option value="manager" {{ $pegawai->role == 'manager' ? 'selected' : '' }}>Manager</option>
            </select>
        </div>
        @if(Auth::user()->isOwner())
        <div class="mb-3">
            <label class="block font-medium mb-1">Cabang</label>
            <select name="cabang_id" class="w-full border rounded px-3 py-2" required>
                @foreach($cabangs as $cabang)
                    <option value="{{ $cabang->id }}" {{ $pegawai->cabang_id == $cabang->id ? 'selected' : '' }}>{{ $cabang->nama_toko }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="flex justify-end gap-2">
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('pegawai.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection