<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kolam;
use App\Models\Siklus;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index($kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->where('id', $siklusId)->firstOrFail();

        $siklusTerpilih = $siklus->monitoring;

        $siklusBerjalan = ($siklus->tanggal_selesai === null);

        return view('dashboard.tambak-udang.monitoring.index', compact('kolam', 'siklus', 'siklusTerpilih', 'siklusBerjalan'));
    }

    public function create($kolamId, $siklusId)
    {

        $kolam = Kolam::findOrFail($kolamId);
        $siklus = Siklus::findOrFail($siklusId);

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
            'tanggal' => 'required|date',
            'waktu_pengukuran' => 'required',
        ]);

        $kolam = Kolam::findOrFail($kolamId);

        $siklusSaatIni = $kolam->siklus()->whereNull('tanggal_selesai')->first();

        $user = auth()->user();

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
        $monitoring->catatan = $request->catatan;

        $monitoring->user()->associate($user);
        $monitoring->siklus()->associate($siklusSaatIni);

        $kolam->monitoring()->save($monitoring);

        return redirect()->route('monitoring', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data monitoring berhasil disimpan.');
    }

    public function edit($kolamId, $siklusId, $monitoringId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->where('id', $siklusId)->firstOrFail();
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
            'tanggal' => 'required|date',
            'waktu_pengukuran' => 'required',
        ]);

        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->where('id', $siklusId)->firstOrFail();
        $monitoring = $siklus->monitoring()->findOrFail($monitoringId);

        $monitoring->update([
            'suhu' => $request->suhu,
            'ph' => $request->ph,
            'do' => $request->do,
            'salinitas' => $request->salinitas,
            'kecerahan' => $request->kecerahan,
            'tinggi_air' => $request->tinggi_air,
            'warna_air' => $request->warna_air,
            'nitrit' => $request->nitrit,
            'amonia' => $request->amonia,
            'catatan' => $request->catatan,
            'tanggal' => $request->tanggal,
            'waktu_pengukuran' => $request->waktu_pengukuran,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('monitoring', ['kolamId' => $kolam->id, 'siklus' => $siklus->id])->with('success', 'Data berhasil diubah');
    }

    public function destroy($kolamId, $siklusId, $monitoringId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->where('id', $siklusId)->firstOrFail();
        $monitoring = $siklus->monitoring()->findOrFail($monitoringId);

        $monitoring->delete();

        return redirect()->route('monitoring', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data berhasil dihapus');
    }
}
