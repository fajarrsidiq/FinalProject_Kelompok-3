<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
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
            text-align: right;
        }
        .total-section {
            text-align: right;
            margin-top: 15pt;
            padding-top: 10pt;
            border-top: 1px solid #adb5bd;
            font-weight: bold;
            font-size: 11pt;
        }
        .total-section p {
            margin-bottom: 4pt;
        }
        .footer {
            margin-top: 25pt;
            text-align: center;
            font-size: 9pt;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
            padding-top: 10pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>MINISHOP - PAK JAYUSMAN</h1>
        <p>Laporan Transaksi Penjualan</p>
    </div>

    <div class="filter-info">
        <strong>Periode:</strong> {{ date('d/m/Y', strtotime($request->dari_tanggal)) }} - {{ date('d/m/Y', strtotime($request->sampai_tanggal)) }}<br>
        <strong>Cabang:</strong> {{ $request->cabang_id ? \App\Models\Cabang::find($request->cabang_id)->nama_toko : 'Semua Cabang' }}<br>
        <strong>Kasir:</strong> {{ $request->kasir_id ? \App\Models\User::find($request->kasir_id)->nama_lengkap : 'Semua Kasir' }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:25%">No. Invoice</th>
                <th style="width:25%">Tanggal</th>
                <th style="width:20%">Cabang</th>
                <th style="width:20%">Kasir</th>
                <th style="width:10%">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $trx)
            <tr>
                <td>{{ $trx->no_invoice }}</td>
                <td>{{ $trx->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                <td>{{ $trx->cabang->nama_toko }}</td>
                <td>{{ $trx->kasir->nama_lengkap }}</td>
                <td>{{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p>Total Transaksi : {{ $totalTransaksi }}</p>
        <p>Total Pendapatan : Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>

    <div class="footer">
        Dicetak pada : {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>