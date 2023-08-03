<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kolam;
use App\Models\Siklus;
use App\Models\Karyawan;
use App\Models\Logistik;
use App\Models\Finansial;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $karyawan = Karyawan::all();

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

        // Total Saldo Awal
        $saldoAwal = $finansialList->where('jenis_transaksi','Saldo Awal');
        $totalSaldoAwal = 0;
        foreach ($saldoAwal as $row) {
            $totalSaldoAwal += $row->jumlah;
        }
        // Total Pemasukan
        $pemasukan = $finansialList->whereIn('jenis_transaksi', ['Pemasukan', 'Penjualan Udang']);
        $totalPemasukan = 0;
        foreach ($pemasukan as $row) {
            $totalPemasukan += $row->jumlah;
        }
        // Total Pengeluaran
        $pengeluaran = $finansialList->whereIn('jenis_transaksi', ['Pengeluaran', 'Gaji Karyawan', 'Bonus Karyawan']);
        $totalPengeluaran = 0;
        foreach ($pengeluaran as $row) {
            $totalPengeluaran += $row->jumlah;
        }
        $bonus = $finansialList->where('jenis_transaksi', 'Bonus Karyawan');
        $totalBonus = 0;
        foreach ($bonus as $row) {
            $totalBonus += $row->jumlah;
        }
        // Total Penjualan Udang
        $penjualan = $finansialList->where('jenis_transaksi', 'Penjualan Udang');
        $totalPenjualan = 0;
        foreach ($penjualan as $row) {
            $totalPenjualan += $row->jumlah;
        }
        // Keuntungan Kotor
        $keuntunganKotor = $totalPemasukan - ($totalPengeluaran - $totalBonus);
        // Bonus Karyawan
        $totalBonusKaryawan = (Karyawan::sum('bonus') / 100) * $keuntunganKotor;

        // Pemasukan
        $pemasukanBulanan = $pemasukan->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('F');
        })->map(function ($group) {
            return $group->sum('jumlah');
        });

        // Pengeluaran
        $pengeluaranBulanan = $pengeluaran->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('F');
        })->map(function ($group) {
            return $group->sum('jumlah');
        });

        $data = [
            'finansial' => $finansial->all(),
            'karyawan' => $karyawan,
            'finansialList' => $finansialList,
            'siklusList' => $siklusList,
            'pemasukanBulanan' => $pemasukanBulanan,
            'pengeluaranBulanan' => $pengeluaranBulanan,
            'totalSaldoAwal' => $totalSaldoAwal,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPenjualan' => $totalPenjualan,
            'keuntunganKotor' => $keuntunganKotor,
            'totalBonusKaryawan' => $totalBonusKaryawan,
            'totalBonus' => $totalBonus,
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
        $kolam = Kolam::all();
        $siklusId = $request->query('siklus_id');

        $finansial = new Finansial();

        $siklusId = $request->query('siklus_id');

        if ($siklusId) {
            $finansialList = $finansial->where('siklus_id', $siklusId)->get();
        } else {
            $finansialList = $finansial->get();
        }

        // Total Pemasukan
        $pemasukan = $finansialList->whereIn('jenis_transaksi', ['Pemasukan', 'Penjualan Udang']);
        $totalPemasukan = 0;
        foreach ($pemasukan as $row) {
            $totalPemasukan += $row->jumlah;
        }
        // Total Pengeluaran
        $pengeluaran = $finansialList->whereIn('jenis_transaksi', ['Pengeluaran', 'Gaji Karyawan', 'Bonus Karyawan']);
        $totalPengeluaran = 0;
        foreach ($pengeluaran as $row) {
            $totalPengeluaran += $row->jumlah;
        }
        $bonus = $finansialList->where('jenis_transaksi', 'Bonus Karyawan');
        $totalBonus = 0;
        foreach ($bonus as $row) {
            $totalBonus += $row->jumlah;
        }
        // Total Penjualan Udang
        $penjualan = $finansialList->where('jenis_transaksi', 'Penjualan Udang');
        $totalPenjualan = 0;
        foreach ($penjualan as $row) {
            $totalPenjualan += $row->jumlah;
        }
        // Keuntungan Kotor
        $keuntunganKotor = $totalPemasukan - ($totalPengeluaran - $totalBonus);
        return view("dashboard.finansial.create", compact('karyawan', 'kolam', 'finansialList', 'siklusId', 'keuntunganKotor'));
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
        ]);

        $jenisTransaksi = $request->input('jenis_transaksi');
        $finansial = new Finansial();

        if ($jenisTransaksi === 'Gaji Karyawan' || $jenisTransaksi === 'Bonus Karyawan') {
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
        $kolam = Kolam::all();
        return view("dashboard.finansial.edit", compact('finansial', 'karyawan', 'kolam'));
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
        ]);

        $jenisTransaksi = $request->input('jenis_transaksi');

        if ($jenisTransaksi === 'Gaji Karyawan' || $jenisTransaksi === 'Bonus Karyawan') {
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


        Finansial::where('id', $finansial->id)->update([
            'tanggal' => $request->tanggal,
            'jenis_transaksi' => $request->jenis_transaksi,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'catatan' => $request->catatan,
            'status' => $request->status,
        ]);

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
        $logistik = Logistik::where('id', $finansial->logistik_id)->first();
        if ($logistik) {
            $logistik->delete();
        }

        return redirect()->route('finansial.index')->with('success', "Data Catatan Finansial Berhasil Dihapus");
    }

    public function export($siklusId)
    {
        $siklus = Siklus::findOrFail($siklusId);
        $finansial = Finansial::all();
        $kolam = Kolam::all();

        if ($siklusId) {
            $finansialList = $finansial->where('siklus_id', $siklusId);
        } else {
            $finansialList = $finansial;
        }

        $pengeluaran = $finansialList->whereIn('jenis_transaksi', ['Pengeluaran', 'Gaji Karyawan', 'Bonus Karyawan']);
        $totalPengeluaran = 0;
        foreach ($pengeluaran as $row) {
            $totalPengeluaran += $row->jumlah;
        }
        $bonus = $finansialList->where('jenis_transaksi', 'Bonus Karyawan');
        $totalBonus = 0;
        foreach ($bonus as $row) {
            $totalBonus += $row->jumlah;
        }

        // Total Pemasukan
        $pemasukan = $finansialList->whereIn('jenis_transaksi', ['Pemasukan', 'Penjualan Udang']);
        $totalPemasukan = 0;
        foreach ($pemasukan as $row) {
            $totalPemasukan += $row->jumlah;
        }

        // Total Penjualan Udang
        $penjualan = $finansialList->where('jenis_transaksi', 'Penjualan Udang');
        $totalPenjualan = 0;
        foreach ($penjualan as $row) {
            $totalPenjualan += $row->jumlah;
        }

        // Keuntungan
        $keuntungan = $totalPemasukan - ($totalPengeluaran - $totalBonus);
        // Bonus Karyawan
        $totalBonusKaryawan = (Karyawan::sum('bonus') / 100) * $keuntungan;

        // dd($kolam);

        $data = [
            'siklus' => $siklus,
            'kolam' => $kolam,
            'finansialList' => $finansialList,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPenjualan' => $totalPenjualan,
            'totalBonusKaryawan' => $totalBonusKaryawan,
            'keuntungan' => $keuntungan,
        ];


        // Create a new Dompdf object

        // Set the font to Times New Roman
        $pdf = Pdf::setOption(['defaultFont' => 'Figtree'])->loadView('dashboard.finansial.reportpdf', $data);
        return $pdf->stream();
    }
}
