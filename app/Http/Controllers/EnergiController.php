<?php

namespace App\Http\Controllers;

use App\Models\Energi;
use App\Models\Kolam;
use Illuminate\Http\Request;

class EnergiController extends Controller
{
    public function index($kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->where('id', $siklusId)->firstOrFail();
        $siklusTerpilih = $siklus->energi()->orderBy('created_at', 'desc')->get();
        $siklusBerjalan = ($siklus->tanggal_selesai === null);

        return view('dashboard.tambak-udang.energi.index', compact('kolam', 'siklus', 'siklusTerpilih', 'siklusBerjalan'));
    }

    public function create($kolamId, $siklusId)
    {

        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->where('id', $siklusId)->firstOrFail();

        return view('dashboard.tambak-udang.energi.create', compact('kolam', 'siklus'));
    }

    public function store(Request $request, $kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);

        $siklusSaatIni = $kolam->siklus()->whereNull('tanggal_selesai')->first();

        $user = auth()->user();

        $validation = $request->validate([
            'tanggal' => 'required|date',
            'penggunaan' => 'required',
            'sumber_energi' => 'required',
            'jumlah' => 'required|numeric',
            'daya' => 'required|numeric',
            'lama_penggunaan' => 'required|numeric',
        ]);

        $kwh = ($validation['daya'] / 1000) * $validation['lama_penggunaan'] * $validation['jumlah'];

        $energi = new Energi();
        $energi->tanggal = $validation['tanggal'];
        $energi->penggunaan = $validation['penggunaan'];
        $energi->sumber_energi = $validation['sumber_energi'];
        $energi->jumlah = $validation['jumlah'];
        $energi->daya = $validation['daya'];
        $energi->lama_penggunaan = $validation['lama_penggunaan'];
        $energi->kwh = $kwh;
        $energi->catatan = $request->catatan;
        $energi->user()->associate($user);
        $energi->siklus()->associate($siklusSaatIni);

        $kolam->energi()->save($energi);

        return redirect()->route('energi.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data perlakuan berhasil disimpan.');
    }
}
