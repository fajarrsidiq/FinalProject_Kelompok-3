<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $query = User::where('role', '!=', 'owner');
        if (!$user->isOwner()) {
            $query->where('cabang_id', $user->cabang_id);
        }
        $pegawais = $query->paginate(10);
        return view('pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cabangs = $user->isOwner() ? Cabang::all() : collect();
        return view('pegawai.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:kasir,gudang,supervisor,manager',
            'cabang_id' => 'nullable|exists:cabang_toko,id'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isOwner()) {
            $data['cabang_id'] = $user->cabang_id;
        }

        User::create($data);
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit(User $pegawai)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cabangs = $user->isOwner() ? Cabang::all() : collect();
        return view('pegawai.edit', compact('pegawai', 'cabangs'));
    }

    public function update(Request $request, User $pegawai)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $pegawai->id,
            'role' => 'required|in:kasir,gudang,supervisor,manager',
            'cabang_id' => 'nullable|exists:cabang_toko,id',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isOwner()) {
            $data['cabang_id'] = $user->cabang_id;
        }

        $pegawai->update($data);
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy(User $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }

    public function toggleStatus(User $pegawai)
    {
        $pegawai->is_active = !$pegawai->is_active;
        $pegawai->save();
        $status = $pegawai->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Pegawai berhasil {$status}.");
    }
}

