<?php

namespace App\Http\Controllers;

use App\Models\Finansial;
use Illuminate\Http\Request;

class FinansialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finansial = Finansial::all();

        // Total Pemasukan
        $pemasukan = Finansial::where('jenis_transaksi', 'Pemasukan')->get();
        $totalPemasukan = 0;
        foreach ($pemasukan as $row) {
            $totalPemasukan += $row->jumlah;
        }
        // Total Pengeluaran
        $pengeluaran = Finansial::where('jenis_transaksi', 'Pengeluaran')->get();
        $totalPengeluaran = 0;
        foreach ($pengeluaran as $row) {
            $totalPengeluaran += $row->jumlah;
        }
        return view("dashboard.finansial.index", compact('finansial'), ['totalPemasukan' => $totalPemasukan, 'totalPengeluaran' => $totalPengeluaran]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.finansial.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis_transaksi' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string', 'max:255'],
            'jumlah' => ['required', 'numeric'],
            'catatan' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        $data = $request->all();

        // Hitung total saldo berdasarkan transaksi sebelumnya
        $totalSaldoSebelumnya = 0;

        // Cek apakah ada transaksi sebelumnya
        $dataSebelumnya = Finansial::where('id', '<', $request->id)->orderBy('id', 'desc')->first();


        if ($dataSebelumnya) {
            $totalSaldoSebelumnya = $dataSebelumnya->total_saldo;
        }

        // Periksa jenis transaksi dan update total saldo
        if ($data['jenis_transaksi'] === 'Pemasukan') {
            $totalSaldo = $totalSaldoSebelumnya + $data['jumlah'];
        } elseif ($data['jenis_transaksi'] === 'Pengeluaran' || $data['jenis_transaksi'] === 'Gaji Karyawan') {
            $totalSaldo = $totalSaldoSebelumnya - $data['jumlah'];
        } else {
            $totalSaldo = $totalSaldoSebelumnya;
        }

        Finansial::create([
            'tanggal' => $request->tanggal,
            'jenis_transaksi' => $request->jenis_transaksi,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'catatan' => $request->catatan,
            'status' => $request->status,
            'total_saldo' => $totalSaldo
        ]);

        return redirect()->route('finansial.index')->with('success', "Catatan Finansial berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Finansial  $finansial
     * @return \Illuminate\Http\Response
     */
    public function show(Finansial $finansial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finansial  $finansial
     * @return \Illuminate\Http\Response
     */
    public function edit(Finansial $finansial)
    {
        return view("dashboard.finansial.edit", compact('finansial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finansial  $finansial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Finansial $finansial)
    {
        $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis_transaksi' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string', 'max:255'],
            'jumlah' => ['required', 'numeric'],
            'catatan' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        $data = $request->all();

        // Hitung total saldo berdasarkan transaksi sebelumnya
        $totalSaldoSebelumnya = 0;

        // Cek apakah ada transaksi sebelumnya
        $dataSebelumnya = Finansial::where('id', '<', $finansial->id)->orderBy('id', 'desc')->first();

        if ($dataSebelumnya) {
            $totalSaldoSebelumnya = $dataSebelumnya->total_saldo;
        }

        // Periksa jenis transaksi dan update total saldo
        if ($data['jenis_transaksi'] === 'Pemasukan') {
            $totalSaldo = $totalSaldoSebelumnya + $data['jumlah'];
        } elseif ($data['jenis_transaksi'] === 'Pengeluaran' || $data['jenis_transaksi'] === 'Gaji Karyawan') {
            $totalSaldo = $totalSaldoSebelumnya - $data['jumlah'];
        } else {
            $totalSaldo = $totalSaldoSebelumnya;
        }

        Finansial::where('id', $finansial->id)->update([
            'tanggal' => $request->tanggal,
            'jenis_transaksi' => $request->jenis_transaksi,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'catatan' => $request->catatan,
            'status' => $request->status,
            'total_saldo' => $totalSaldo
        ]);

        // Perbarui total saldo data setelahnya
        $dataSetelahnya = Finansial::where('id', '>', $finansial->id)->get();

        foreach ($dataSetelahnya as $data) {
            $dataSebelumnya = Finansial::where('id', '<', $data['id'])->orderBy('id', 'desc')->first();
            $totalSaldoSebelumnya = $dataSebelumnya->total_saldo;
            if ($data['jenis_transaksi'] === 'Pemasukan') {
                $totalSaldoBaru = $totalSaldoSebelumnya + $data['jumlah'];
                $data->update([
                    'total_saldo' => $totalSaldoBaru
                ]);
            } elseif ($data['jenis_transaksi'] === 'Pengeluaran' || $data['jenis_transaksi'] === 'Gaji Karyawan') {
                $totalSaldoBaru = $totalSaldoSebelumnya - $data['jumlah'];
                $data->update([
                    'total_saldo' => $totalSaldoBaru
                ]);
            } else {
                $totalSaldoBaru = $totalSaldoSebelumnya;
                $data->update([
                    'total_saldo' => $totalSaldoBaru
                ]);
            }
            
        }

        return redirect()->route('finansial.index')->with('success', "Data Catatan Finansial Berhasil Diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finansial  $finansial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Finansial $finansial)
    {
        $finansial->delete();

        return redirect()->route('finansial.index')->with('success', "Data Catatan Finansial Berhasil Dihapus");
    }
}
