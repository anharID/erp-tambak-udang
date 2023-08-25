<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Keuangan</title>
</head>

<style>
    .w-full {
        width: 100%;
    }

    .text-center {
        text-align: center;
    }

    .table {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
        border-collapse: collapse;
        text-align: left;
        margin-top: 10px;
        /* width: 100%; */
    }

    .table td,
    .table th {
        border: 1px solid #ddd;
        padding: 4px;
        /* text-align: center; */
    }

    .table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #bdc8ff;
        /* color: white; */
        /* text-align: center; */
    }

    p {
        margin: 0;
        padding: 0;
    }

    h3 {
        margin: 20px 0 5px 0;
    }

    h5 {
        margin: 0;
    }

    .mb {
        margin-bottom: 10px
    }

    .text-red {
        color: red;
    }

    .text-green {
        color: green;
    }

    .caption {
        font-style: italic;
        color: gray;
        font-size: 10pt;
    }
</style>

<body>
    <div class="text-center">
        <h1>Laporan Keuangan</h1>
        <h4>CV Riz Samudera</h4>
    </div>
    <table>
        <tbody>
            <tr>
                <td>Periode Siklus</td>
                <td>:</td>
                <td>{{ Carbon\Carbon::parse($siklus->tanggal_mulai)->format('j F o') }}</td>
            </tr>
        </tbody>
    </table>
    <h3>Rekap Penjualan Udang</h3>
    <table class="table w-full">
        <thead>
            <tr>
                <th>Kolam</th>
                <th>Tanggal</th>
                <th>Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($finansialList->where('jenis_transaksi', 'Penjualan Udang')->groupBy('keterangan') as $row => $items)
                @php
                    $rowspan = count($items);
                @endphp
                @foreach ($items as $index => $item)
                    <tr>
                        @if ($index === 0)
                            <td rowspan="{{ $rowspan }}">{{ $row }}</td>
                        @endif
                        <td>{{ Carbon\Carbon::parse($item->tanggal)->format('j F o') }}</td>
                        <td>{{ 'Rp ' . number_format($item->jumlah, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
            <tr>
                <th colspan="2">Total</th>
                <th>{{ 'Rp ' . number_format($totalPenjualan, 2, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
    <h3>Pemasukan</h3>
    <table class="table w-full">
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($finansialList->whereIn('jenis_transaksi', ['Pemasukan', 'Penjualan Udang'])->sortBy('tanggal') as $row)
                <tr>
                    <td>{{ $row->keterangan }}</td>
                    <td>{{ Carbon\Carbon::parse($row->tanggal)->format('j F o') }}</td>
                    <td>{{ 'Rp ' . number_format($row->jumlah, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2">Total</th>
                <th>{{ 'Rp ' . number_format($totalPemasukan, 2, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
    <h3>Pengeluaran</h3>
    <table class="table w-full">
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($finansialList->whereIn('jenis_transaksi', ['Pengeluaran', 'Gaji Karyawan', 'Bonus Karyawan'])->sortBy('tanggal') as $row)
                <tr>
                    <td>{{ $row->keterangan }}</td>
                    <td>{{ Carbon\Carbon::parse($row->tanggal)->format('j F o') }}</td>
                    <td>{{ 'Rp ' . number_format($row->jumlah, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2">Total</th>
                <th>{{ 'Rp ' . number_format($totalPengeluaran, 2, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
    <h3>Laba/Rugi</h3>
    <table class="table w-full">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pemasukan</td>
                <td>{{ 'Rp ' . number_format($totalPemasukan, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Penjualan Udang</td>
                <td>{{ 'Rp ' . number_format($totalPenjualan, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Pengeluaran</td>
                <td>{{ 'Rp ' . number_format($totalPengeluaran, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Bonus Karyawan</td>
                <td>{{ 'Rp ' . number_format($totalBonusKaryawan, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Pendapatan Bersih</th>
                <th>{{ 'Rp ' . number_format($keuntungan - $totalBonusKaryawan, 2, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
</body>

</html>
