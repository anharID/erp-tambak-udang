<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kolam;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index($kolamId)
    {
        $kolam = Kolam::findOrFail($kolamId);

        $siklusSaatIni = $kolam->siklus()->whereNull('tanggal_selesai')->first();

        if ($siklusSaatIni) {
            $monitoring = $kolam->monitoring()->get();
            $monitoringsAktif = $siklusSaatIni->monitoring;

            return view('dashboard.tambak-udang.monitoring.index', compact('kolam', 'siklusSaatIni', 'monitoringsAktif'));
        }
        return view('dashboard.tambak-udang.monitoring.index', compact('kolam', 'siklusSaatIni'));
    }

    public function create($kolamId)
    {

        $kolam = Kolam::findOrFail($kolamId);
        return view('dashboard.tambak-udang.monitoring.create', compact('kolam'));
    }

    public function store(Request $request, $kolamId)
    {
        $validation = $request->validate([
            'suhu' => 'required|numeric',
            'ph' => 'required|numeric',
            'do' => 'required|numeric',
            'salinitas' => 'required|numeric',
            'kecerahan' => 'required|numeric',
            'tinggi_air' => 'required|numeric',
            'warna_air' => 'required',
            'tanggal' => 'required|date',
            'waktu_pengukuran' => 'required|date_format:H:i',
        ]);

        $kolam = Kolam::findOrFail($kolamId);

        $siklusSaatIni = $kolam->siklus()->whereNull('tanggal_selesai')->first();

        $user = auth()->user();

        // $kolam->monitoring()->create([
        //     $validation['suhu'],
        //     $validation['ph'],
        //     $validation['do'],
        //     $validation['salinitas'],
        //     $validation['kecerahan'],
        //     $validation['tinggi_air'],
        //     $validation['warna_air'],
        //     $request->nitrit,
        //     $request->amonia,
        //     $validation['tanggal'],
        //     $validation['waktu_pengukuran'],
        // ]);

        $monitoring = new Monitoring();

        $monitoring->suhu = $validation['suhu'];
        $monitoring->ph = $validation['ph'];
        $monitoring->do = $validation['do'];
        $monitoring->salinitas = $validation['salinitas'];
        $monitoring->kecerahan = $validation['kecerahan'];
        $monitoring->tinggi_air = $validation['tinggi_air'];
        $monitoring->warna_air = $validation['warna_air'];
        $monitoring->nitrit = $request->nitrit;
        $monitoring->amonia = $request->amonia;
        $monitoring->tanggal = $validation['tanggal'];
        $monitoring->waktu_pengukuran = $validation['waktu_pengukuran'];

        $monitoring->user()->associate($user);
        $monitoring->siklus()->associate($siklusSaatIni);

        $kolam->monitoring()->save($monitoring);

        return redirect()->route('monitoring', $kolamId)->with('success', 'Data monitoring berhasil disimpan.');
    }
}
