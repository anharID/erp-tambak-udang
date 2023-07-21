<?php

namespace App\Http\Controllers;

use App\Models\Finansial;
use App\Models\Inventaris;
use App\Models\Kolam;
use App\Models\Siklus;
use App\Models\Karyawan;
use App\Models\Peralatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $siklusSaatIni = Siklus::where('tanggal_selesai', null)->first();
        $kolamAktif = Kolam::where('status', 1)->get()->count();
        $karyawan = Karyawan::all()->count();
        $saldo = Finansial::latest()->first()->total_saldo;
        $itemInventaris = Inventaris::all()->count();
        $maintenance = Peralatan::where('maintenance', 1)->get()->count();
        // dd($saldo);

        $data = [
            'kolamAktif' => $kolamAktif,
            'karyawan' => $karyawan,
            'saldo' => $saldo,
            'itemInventaris' => $itemInventaris,
            'maintenance' => $maintenance,
        ];

        return view('dashboard.dashboard', $data);
    }
}
