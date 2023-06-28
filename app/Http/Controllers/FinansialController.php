<?php

namespace App\Http\Controllers;

use App\Models\Finansial;
use App\Models\Siklus;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinansialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $finansial = new Finansial();

        $siklusId = $request->query('siklus_id');
        $siklusList = Siklus::all();

        if ($siklusId) {
            $finansialList = $finansial->where('siklus_id', $siklusId)->get();
        } else {
            $finansialList = $finansial->get();
        }

        // Ambil siklus berjalan saat ini
        $siklusSaatIni = Siklus::whereNull('tanggal_selesai')->first();
        // Ambil siklus selesai
        $siklusSelesai = Siklus::whereNotNull('tanggal_selesai')->orderBy('tanggal_mulai', 'desc')->get();

        // Total Pemasukan
        $pemasukan = $finansialList->where('jenis_transaksi', 'Pemasukan');
        $totalPemasukan = 0;
        foreach ($pemasukan as $row) {
            $totalPemasukan += $row->jumlah;
        }
        // Total Pengeluaran
        $pengeluaran = $finansialList->whereIn('jenis_transaksi', ['Pengeluaran', 'Gaji Karyawan']);
        $totalPengeluaran = 0;
        foreach ($pengeluaran as $row) {
            $totalPengeluaran += $row->jumlah;
        }

        // Bulan
        $bulan = Finansial::all()->groupby(function($item){
            return Carbon::parse($item->tanggal)->format('F');
        });
        
        // Pemasukan
        $pemasukanBulanan = $pemasukan->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('F');
        })->map(function ($group) {
            return $group->sum('jumlah');
        });
        
        $labels = $bulan->keys();
        
        $valuesPemasukan = $pemasukanBulanan->values();
        
        $chartDataPemasukan = [
            'labels' => $labels,
            'values' => $valuesPemasukan,
        ];

        // Pengeluaran
        $pengeluaranBulanan = $pengeluaran->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('F');
        })->map(function ($group) {
            return $group->sum('jumlah');
        });
        
        $valuesPengeluaran = $pengeluaranBulanan->values();
        
        $chartDataPengeluaran = [
            'labels' => $labels,
            'values' => $valuesPengeluaran,
        ];

        $data = [
            'finansial' => $finansial->all(),
            'finansialList' => $finansialList,
            'siklusList' => $siklusList,
            'chartDataPemasukan' => $chartDataPemasukan,
            'chartDataPengeluaran' => $chartDataPengeluaran,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'siklusSaatIni' => $siklusSaatIni,
            'siklusSelesai' => $siklusSelesai
        ];

        if (!$siklusId && $siklusSaatIni) {
            return redirect()->route('finansial.index', ['siklus_id' => $siklusSaatIni]);
        }
        
        return view("dashboard.finansial.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $karyawan = Karyawan::all();
        $siklusId = $request->query('siklus_id');
        return view("dashboard.finansial.create", compact('karyawan', 'siklusId'));
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

        $jenisTransaksi = $request->input('jenis_transaksi');
        $finansial = new Finansial();

        if ($jenisTransaksi === 'Gaji Karyawan') {
            $karyawanID = $request->input('karyawan');
            // Simpan data ke dalam tabel finansial
            $finansial->karyawan_id = $karyawanID;
            $finansial->siklus_id = $request->input('siklus_id');
            $finansial->tanggal = $request->tanggal;
            $finansial->jenis_transaksi = $jenisTransaksi;
            $finansial->jumlah = $request->jumlah;
            $finansial->keterangan = $request->keterangan;
            $finansial->catatan = $request->catatan;
            $finansial->status = $request->status;
            $finansial->save();
        } else {
            // Simpan data ke dalam tabel finansial
            $finansial->siklus_id = $request->input('siklus_id');
            $finansial->tanggal = $request->input('tanggal');
            $finansial->jenis_transaksi = $jenisTransaksi;
            $finansial->jumlah = $request->input('jumlah');
            $finansial->keterangan = $request->input('keterangan');
            $finansial->catatan = $request->catatan;
            $finansial->status = $request->status;
            $finansial->save();
        }

        // Hitung total saldo berdasarkan transaksi sebelumnya
        $totalSaldoSebelumnya = 0;

        // Cek apakah ada transaksi sebelumnya
        $dataSebelumnya = Finansial::where('id', '<', $finansial->id)->orderBy('id', 'desc')->first();

        if ($dataSebelumnya) {
            $totalSaldoSebelumnya = $dataSebelumnya->total_saldo;
        }

        // Periksa jenis transaksi dan update total saldo
        if ($request->jenis_transaksi === 'Pemasukan') {
            $totalSaldo = $totalSaldoSebelumnya + $request->jumlah;
        } elseif ($request->jenis_transaksi === 'Pengeluaran' || $request->jenis_transaksi === 'Gaji Karyawan') {
            $totalSaldo = $totalSaldoSebelumnya - $request->jumlah;
        } else {
            $totalSaldo = $totalSaldoSebelumnya;
        }

        $finansial->update([
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
        $karyawan = Karyawan::all();
        return view("dashboard.finansial.edit", compact('finansial', 'karyawan'));
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
        $jenisTransaksi = $request->input('jenis_transaksi');

        if ($jenisTransaksi === 'Gaji Karyawan') {
            $karyawanID = $request->input('karyawan');
            // Simpan data ke dalam tabel finansial
            $finansial->karyawan_id = $karyawanID;
            $finansial->tanggal = $request->tanggal;
            $finansial->jenis_transaksi = $jenisTransaksi;
            $finansial->jumlah = $request->jumlah;
            $finansial->keterangan = $request->keterangan;
            $finansial->catatan = $request->catatan;
            $finansial->status = $request->status;
            $finansial->save();
        } else {
            // Simpan data ke dalam tabel finansial
            $finansial->tanggal = $request->input('tanggal');
            $finansial->jenis_transaksi = $jenisTransaksi;
            $finansial->jumlah = $request->input('jumlah');
            $finansial->keterangan = $request->input('keterangan');
            $finansial->catatan = $request->catatan;
            $finansial->status = $request->status;
            $finansial->save();
        }

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
