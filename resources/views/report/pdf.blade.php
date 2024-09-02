<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            color: #333;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            color: #007BFF;
        }

        header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tfoot {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        footer {
            text-align: center;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 0;
            background-color: #f9f9f9;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <header>
        <h1>Laporan Penjualan</h1>
        <p>Periode: {{ Carbon\Carbon::parse(request('start'))->format('d-m-Y') }} sampai
            {{ Carbon\Carbon::parse(request('end'))->format('d-m-Y') }}</p>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th class="text-center">Stok Awal</th>
                <th class="text-center">Stok Akhir</th>
                <th class="text-center">Quantity</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ tanggal_indonesia($item->tanggal) }}</td>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td class="text-center">{{ $stokAwal }}</td>
                    <td class="text-center">{{ $stokAkhir }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ format_uang($item->price) }}</td>
                    <td class="text-right">{{ format_uang($item->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">Total</td>
                <td class="text-right">{{ format_uang($data->sum('subtotal')) }}</td>
            </tr>
        </tfoot>
    </table>

    <footer>
        <p>&copy; {{ date('Y') }} Laporan Penjualan. Semua Hak Dilindungi.</p>
    </footer>
</body>

</html>
