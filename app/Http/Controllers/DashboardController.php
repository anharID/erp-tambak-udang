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
        } else {
            $doc = null;
        }



        //data untuk overview
        $kolamJumlah = Kolam::all()->count();
        $karyawan = Karyawan::all()->count();
        $finansialakhir = Finansial::latest()->first();
        $saldo = 0;
        if ($finansialakhir) {
            $saldo = $finansialakhir->saldo_akhir;
        }
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
