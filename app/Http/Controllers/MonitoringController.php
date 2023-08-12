<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kolam;
use App\Models\Siklus;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function __construct()
    {
        // Middleware akan diterapkan hanya pada rute edit dan destroy
        $this->middleware('validated.data')->only(['edit', 'destroy']);
    }

    public function index(Request $request, $kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);

        $siklusTerpilih = $siklus->monitoring()->where('kolam_id', $kolam->id)->orderBy('tanggal', 'desc')->orderBy('waktu_pengukuran', 'desc')->get();

        $siklusBerjalan = ($siklus->tanggal_selesai === null);

        function getChartData($siklusTerpilih)
        {
            $dataPagi = $siklusTerpilih->filter(function ($item) {
                $time = Carbon::parse($item->waktu_pengukuran);
                return $time->between('00:00:00', '12:00:00');
            })->sortBy('tanggal')->groupby(function ($item) {
                return Carbon::parse($item->tanggal)->format('j M o');
            })->map(function ($group) {
                return $group->first();
            });
            $dataSore = $siklusTerpilih->filter(function ($item) {
                $time = Carbon::parse($item->waktu_pengukuran);
                return $time->between('12:00:00', '23:59:59');
            })->sortBy('tanggal')->groupby(function ($item) {
                return Carbon::parse($item->tanggal)->format('j M o');
            })->map(function ($group) {
                return $group->first();
            });
            return ['dataPagi' => $dataPagi, 'dataSore' => $dataSore];
        };


        $tanggal = $siklusTerpilih->sort()->groupby(function ($item) {
            return Carbon::parse($item->tanggal)->format('j M o');
        });

        $data = getChartData($siklusTerpilih);

        $chartData = [
            'dataPagi' => $data['dataPagi'],
            'dataSore' => $data['dataSore']
        ];

        return view('dashboard.tambak-udang.monitoring.index', compact('kolam', 'siklus', 'siklusTerpilih', 'siklusBerjalan', 'chartData'));
    }

    public function create($kolamId, $siklusId)
    {

        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);

        return view('dashboard.tambak-udang.monitoring.create', compact('kolam', 'siklus'));
    }

    public function store(Request $request, $kolamId, $siklusId)
    {
        $validation = $request->validate([
            'suhu' => 'required|numeric',
            'ph' => 'required|numeric',
            'do' => 'required|numeric',
            'salinitas' => 'required|numeric',
            'kecerahan' => 'required|numeric',
            'tinggi_air' => 'required|numeric',
            'warna_air' => 'required',
            'cuaca' => 'required',
            'tanggal' => 'required|date',
            'waktu_pengukuran' => 'required',
        ]);

        $kolam = Kolam::findOrFail($kolamId);

        $siklusSaatIni = $kolam->siklus()->whereNull('tanggal_selesai')->first();

        // $user = auth()->user();

        $monitoring = new Monitoring();

        $monitoring->suhu = $validation['suhu'];
        $monitoring->ph = $validation['ph'];
        $monitoring->do = $validation['do'];
        $monitoring->salinitas = $validation['salinitas'];
        $monitoring->kecerahan = $validation['kecerahan'];
        $monitoring->tinggi_air = $validation['tinggi_air'];
        $monitoring->warna_air = $validation['warna_air'];
        $monitoring->cuaca = $validation['cuaca'];
        $monitoring->nitrit = $request->nitrit;
        $monitoring->amonia = $request->amonia;
        $monitoring->tanggal = $validation['tanggal'];
        $monitoring->waktu_pengukuran = $validation['waktu_pengukuran'];
        $monitoring->catatan = $request->catatan;

        // $monitoring->user()->associate($user);
        $monitoring->siklus()->associate($siklusSaatIni);

        $kolam->monitoring()->save($monitoring);

        return redirect()->route('monitoring.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data monitoring berhasil disimpan.');
    }

    public function edit($kolamId, $siklusId, $monitoringId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $monitoring = $siklus->monitoring()->findOrFail($monitoringId);

        return view('dashboard.tambak-udang.monitoring.edit', compact('kolam', 'siklus', 'monitoring'));
    }

    public function update(Request $request, $kolamId, $siklusId, $monitoringId)
    {
        $request->validate([
            'suhu' => 'required|numeric',
            'ph' => 'required|numeric',
            'do' => 'required|numeric',
            'salinitas' => 'required|numeric',
            'kecerahan' => 'required|numeric',
            'tinggi_air' => 'required|numeric',
            'warna_air' => 'required',
            'cuaca' => 'required',
            'tanggal' => 'required|date',
            'waktu_pengukuran' => 'required',
        ]);

        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $monitoring = $siklus->monitoring()->findOrFail($monitoringId);

        $monitoring->update([
            'suhu' => $request->suhu,
            'ph' => $request->ph,
            'do' => $request->do,
            'salinitas' => $request->salinitas,
            'kecerahan' => $request->kecerahan,
            'tinggi_air' => $request->tinggi_air,
            'warna_air' => $request->warna_air,
            'cuaca' => $request->cuaca,
            'nitrit' => $request->nitrit,
            'amonia' => $request->amonia,
            'catatan' => $request->catatan,
            'tanggal' => $request->tanggal,
            'waktu_pengukuran' => $request->waktu_pengukuran,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('monitoring.index', ['kolamId' => $kolam->id, 'siklus' => $siklus->id])->with('success', 'Data berhasil diubah');
    }

    public function destroy($kolamId, $siklusId, $monitoringId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $monitoring = $siklus->monitoring()->findOrFail($monitoringId);

        $monitoring->delete();

        return redirect()->route('monitoring.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data berhasil dihapus');
    }

    public function dataValidated($kolamId, $siklusId, $monitoringId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $monitoring = $siklus->monitoring()->findOrFail($monitoringId);

        $monitoring->is_validated = 1;
        $monitoring->save();

        return redirect()->route('monitoring.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data berhasil divalidasi');
    }
}
