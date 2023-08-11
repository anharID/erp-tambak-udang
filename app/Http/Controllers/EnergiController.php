<?php

namespace App\Http\Controllers;

use App\Models\Energi;
use App\Models\Kolam;
use App\Models\PenggunaanEnergi;
use Illuminate\Http\Request;

class EnergiController extends Controller
{
    public function index($kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findORFail($siklusId);
        $siklusTerpilih = $siklus->energi()->where('kolam_id', $kolam->id)->orderBy('created_at', 'desc')->get();
        $siklusBerjalan = ($siklus->tanggal_selesai === null);

        return view('dashboard.tambak-udang.energi.index', compact('kolam', 'siklus', 'siklusTerpilih', 'siklusBerjalan'));
    }

    public function create($kolamId, $siklusId)
    {

        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $penggunaan = PenggunaanEnergi::all();

        return view('dashboard.tambak-udang.energi.create', compact('kolam', 'siklus', 'penggunaan'));
    }

    public function store(Request $request, $kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklusSaatIni = $kolam->siklus()->whereNull('tanggal_selesai')->first();
        // $user = auth()->user();

        $validation = $request->validate([
            'tanggal' => 'required|date',
            'penggunaan_id' => 'required',
            'sumber_energi' => 'required',
            'jumlah' => 'required|numeric',
            'daya' => 'required|numeric',
            'lama_penggunaan' => 'required|numeric',
        ]);

        $kwh = ($validation['daya'] / 1000) * $validation['lama_penggunaan'] * $validation['jumlah'];

        $energi = new Energi();
        $energi->tanggal = $validation['tanggal'];
        $energi->penggunaan_id = $validation['penggunaan_id'];
        $energi->sumber_energi = $validation['sumber_energi'];
        $energi->jumlah = $validation['jumlah'];
        $energi->daya = $validation['daya'];
        $energi->lama_penggunaan = $validation['lama_penggunaan'];
        $energi->kwh = $kwh;
        $energi->catatan = $request->catatan;
        // $energi->user()->associate($user);
        $energi->siklus()->associate($siklusSaatIni);

        $kolam->energi()->save($energi);

        return redirect()->route('energi.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data perlakuan berhasil disimpan.');
    }

    public function edit($kolamId, $siklusId, $energiId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $energi = $siklus->energi()->findOrFail($energiId);
        $penggunaan = PenggunaanEnergi::all();

        return view('dashboard.tambak-udang.energi.edit', compact('kolam', 'siklus', 'energi', 'penggunaan'));
    }

    public function update(Request $request, $kolamId, $siklusId, $energiId)
    {
        $validation = $request->validate([
            'tanggal' => 'required|date',
            'penggunaan_id' => 'required',
            'sumber_energi' => 'required',
            'jumlah' => 'required|numeric',
            'daya' => 'required|numeric',
            'lama_penggunaan' => 'required|numeric',
        ]);

        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $energi = $siklus->energi()->findOrFail($energiId);

        $kwh = ($validation['daya'] / 1000) * $validation['lama_penggunaan'] * $validation['jumlah'];

        $energi->update([
            'tanggal' => $validation['tanggal'],
            'penggunaan_id' => $validation['penggunaan_id'],
            'sumber_energi' => $validation['sumber_energi'],
            'jumlah' => $validation['jumlah'],
            'daya' => $validation['daya'],
            'lama_penggunaan' => $validation['lama_penggunaan'],
            'kwh' => $kwh,
            'catatan' => $request->catatan
        ]);

        return redirect()->route('energi.index', ['kolamId' => $kolam->id, 'siklus' => $siklus->id])->with('success', 'Data berhasil diubah');
    }

    public function destroy($kolamId, $siklusId, $energiId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $energi = $siklus->energi()->findOrFail($energiId);

        $energi->delete();

        return redirect()->route('energi.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data berhasil dihapus');
    }
}
