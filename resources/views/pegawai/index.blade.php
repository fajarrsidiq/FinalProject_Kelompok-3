@extends('components.layouts.app')

@section('title', 'Pegawai')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Daftar Pegawai</h2>
        <a href="{{ route('pegawai.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">+ Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Role</th>
                    <th class="border px-4 py-2">Cabang</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pegawais as $pegawai)
                <tr>
                    <td class="border px-4 py-2">{{ $pegawai->nama_lengkap }}</td>
                    <td class="border px-4 py-2">{{ $pegawai->email }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($pegawai->role) }}</td>
                    <td class="border px-4 py-2">{{ $pegawai->cabang->nama_toko ?? '-' }}</td>
                    <td class="border px-4 py-2">
                        <select class="status-select border rounded px-2 py-1 text-sm" data-id="{{ $pegawai->id }}" data-url="{{ route('pegawai.toggle-status', $pegawai) }}">
                            <option value="1" {{ $pegawai->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$pegawai->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('pegawai.edit', $pegawai) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                        <form action="{{ route('pegawai.destroy', $pegawai) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $pegawais->links() }}
</div>

@push('scripts')
<script>
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            let url = this.dataset.url;
            let status = this.value;
            let row = this.closest('tr');
            let originalValue = this.value;

            fetch(url, {
                method: 'GET',  // route toggle-status menggunakan GET
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tampilkan notifikasi sukses (opsional, bisa menggunakan alert atau toast)
                    // Ubah warna status jika diperlukan
                    let statusCell = row.cells[4];
                    let newBadge = document.createElement('span');
                    newBadge.className = `px-2 py-1 rounded text-xs ${status == '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
                    newBadge.innerText = status == '1' ? 'Aktif' : 'Nonaktif';
                    // Hapus select sementara, ganti dengan badge? Tidak perlu, select tetap ada.
                    // Atau kita refresh halaman? Lebih baik refresh agar konsisten.
                    location.reload();
                } else {
                    alert('Gagal mengubah status');
                    // Kembalikan pilihan ke nilai awal
                    this.value = originalValue;
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan');
                this.value = originalValue;
            });
        });
    });
</script>
@endpush
@endsection
