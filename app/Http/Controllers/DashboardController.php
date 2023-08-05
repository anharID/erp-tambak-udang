<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kolam;
use App\Models\Siklus;
use App\Models\Karyawan;
use App\Models\Finansial;
use App\Models\Peralatan;
use App\Models\Inventaris;
use App\Models\Sampling;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $siklusSaatIni = Siklus::latest()->first();
        $biomassa = 0;
        $panen = 0;
        $pakan = 0;
        // dd($siklusSaatIni);
        if ($siklusSaatIni) {
            $kolam = $siklusSaatIni->kolam;

            foreach ($kolam as $k) {

                $lastSampling = $k->sampling()->where('siklus_id', $siklusSaatIni->id)->latest()->first();
                if ($lastSampling !== null) {
                    $lastBiomassa = $lastSampling->biomas;
                    $biomassa += $lastBiomassa;
                }
            }

            $panen = $siklusSaatIni->panen;
            $pakan = $siklusSaatIni->pakan;
            
            
        }

        if ($siklusSaatIni) {
            $doc = Carbon::now()->diffInDays($siklusSaatIni->tanggal_mulai);
            $finansial = Finansial::where('siklus_id', $siklusSaatIni->id)->get();
        } else {
            $doc = null;
            $finansial = Finansial::get();
        }



        //data untuk overview
        $kolamJumlah = Kolam::all()->count();
        $karyawan = Karyawan::all()->count();
        // Total Saldo Awal
        $saldoAwal = $finansial->where('jenis_transaksi','Saldo Awal');
        $totalSaldoAwal = 0;
        foreach ($saldoAwal as $row) {
            $totalSaldoAwal += $row->jumlah;
        }
        // Total Pemasukan
        $pemasukan = $finansial->whereIn('jenis_transaksi', ['Pemasukan', 'Penjualan Udang']);
        $totalPemasukan = 0;
        foreach ($pemasukan as $row) {
            $totalPemasukan += $row->jumlah;
        }
        // Total Pengeluaran
        $pengeluaran = $finansial->whereIn('jenis_transaksi', ['Pengeluaran', 'Gaji Karyawan', 'Bonus Karyawan']);
        $totalPengeluaran = 0;
        foreach ($pengeluaran as $row) {
            $totalPengeluaran += $row->jumlah;
        }
        $saldo = $totalSaldoAwal + $totalPemasukan - $totalPengeluaran;
        $itemInventaris = Inventaris::all()->count();
        $maintenance = Peralatan::where('maintenance', 1)->get()->count();

        $data = [
            'kolamJumlah' => $kolamJumlah,
            'karyawan' => $karyawan,
            'saldo' => $saldo,
            'itemInventaris' => $itemInventaris,
            'maintenance' => $maintenance,
            'siklus' => $siklusSaatIni,
            'doc' => $doc,
            'biomassa' => $biomassa,
            'panen' => $panen,
            'pakan' => $pakan,
        ];

        return view('dashboard.dashboard', $data);
    }
}
