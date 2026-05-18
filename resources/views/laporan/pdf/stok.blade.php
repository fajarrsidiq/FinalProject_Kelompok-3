<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Barang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 12pt;
            line-height: 1.4;
            padding: 20pt;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20pt;
            border-bottom: 2px solid #4a6fa5;
            padding-bottom: 10pt;
        }
        .header h1 {
            font-size: 18pt;
            color: #2c3e50;
            margin-bottom: 4pt;
        }
        .header p {
            font-size: 10pt;
            color: #6c757d;
        }
        .filter-info {
            background-color: #f8f9fc;
            padding: 10pt;
            margin-bottom: 20pt;
            border-left: 4px solid #4a6fa5;
            font-size: 10pt;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20pt;
            font-size: 10pt;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8pt 6pt;
            vertical-align: top;
        }
        th {
            background-color: #e9ecef;
            font-weight: bold;
            text-align: center;
        }
        td {
            text-align: left;
        }
        td:last-child {
            text-align: center;
        }
        .status-habis {
            color: #dc3545;
            font-weight: bold;
        }
        .status-menipis {
            color: #fd7e14;
            font-weight: bold;
        }
        .status-tersedia {
            color: #28a745;
            font-weight: bold;
        }
        .footer {
            margin-top: 25pt;
            text-align: center;
            font-size: 9pt;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
            padding-top: 10pt;
        }
        .keterangan {
            margin-top: 15pt;
            font-size: 9pt;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>MINISHOP - PAK JAYUSMAN</h1>
        <p>Laporan Stok Barang</p>
    </div>

    <div class="filter-info">
        <strong>Cabang:</strong> {{ $request->cabang_id ? \App\Models\Cabang::find($request->cabang_id)->nama_toko : 'Semua Cabang' }}<br>
        <strong>Kategori:</strong> {{ $request->kategori_id ? \App\Models\KategoriBarang::find($request->kategori_id)->nama_kategori : 'Semua Kategori' }}<br>
        <strong>Status Stok:</strong> 
        @if($request->status == 'tersedia') Tersedia
        @elseif($request->status == 'menipis') Menipis
        @elseif($request->status == 'habis') Habis
        @else Semua @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:15%">Kode</th>
                <th style="width:25%">Nama Barang</th>
                <th style="width:15%">Kategori</th>
                <th style="width:10%">Stok</th>
                <th style="width:10%">Minimal</th>
                <th style="width:10%">Satuan</th>
                <th style="width:15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $barang)
            <tr>
                <td>{{ $barang->kode_barang }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $barang->stok }} {{ $barang->satuan }}</td>
                <td>{{ $barang->stok_minimal }} {{ $barang->satuan }}</td>
                <td>{{ $barang->satuan }}</td>
                <td class="
                    @if($barang->stok <= 0) status-habis
                    @elseif($barang->stok <= $barang->stok_minimal) status-menipis
                    @else status-tersedia @endif">
                    @if($barang->stok <= 0) Habis
                    @elseif($barang->stok <= $barang->stok_minimal) Menipis
                    @else Tersedia @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="keterangan">
        * Stok Minimal: batas minimum stok yang harus dijaga. Jika stok di bawah atau sama dengan nilai minimal, akan berstatus "Menipis".
    </div>

    <div class="footer">
        Dicetak pada : {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>