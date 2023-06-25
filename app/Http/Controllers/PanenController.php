<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\Kolam;
use Illuminate\Http\Request;

class PanenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->find($siklusId);

        $siklusTerpilih = $siklus->panen()->where('kolam_id', $kolam->id)->orderBy('created_at', 'desc')->get();

        $siklusBerjalan = ($siklus->tanggal_selesai === null);

        return view('dashboard.tambak-udang.panen.index', compact('kolam', 'siklus', 'siklusTerpilih', 'siklusBerjalan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        return view('dashboard.tambak-udang.panen.create', compact('kolam', 'siklus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $kolamId, $siklusId)
    {
        $validation = $request->validate([
            'tanggal' => 'required|date',
            'waktu_panen' => 'required',
            'size_besar' => 'required|numeric',
            'size_kecil' => 'required|numeric',
            'tonase_besar' => 'required|numeric',
            'tonase_kecil' => 'required|numeric',
        ]);

        //Data yang diperlukan
        $kolam = Kolam::findOrFail($kolamId);
        $siklusSaatIni = $kolam->siklus()->whereNull('tanggal_selesai')->first();
        $user = auth()->user();

        //ABW
        $abw = 1000 / $validation['size_besar'];

        //Tonase Jumlah
        $tonaseJumlah = $validation['tonase_besar'] + $validation['tonase_kecil'];

        //POPULASI TERAMBIL
        $populasi = ($validation['tonase_besar'] * $validation['size_besar']) + ($validation['tonase_kecil'] * $validation['size_kecil']);

        //Store Data
        $panen = new Panen();
        $panen->tanggal = $validation['tanggal'];
        $panen->waktu_panen = $validation['waktu_panen'];
        $panen->size_besar = $validation['size_besar'];
        $panen->size_kecil = $validation['size_kecil'];
        $panen->tonase_besar = $validation['tonase_besar'];
        $panen->tonase_kecil = $validation['tonase_kecil'];
        $panen->tonase_jumlah = $tonaseJumlah;
        $panen->populasi_terambil = $populasi;
        $panen->abw = $abw;
        $panen->status = $request->status;
        $panen->catatan = $request->catatan;

        $panen->user()->associate($user);
        $panen->siklus()->associate($siklusSaatIni);

        $kolam->panen()->save($panen);

        return redirect()->route('panen.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data sampling berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Panen  $panen
     * @return \Illuminate\Http\Response
     */
    public function show(Panen $panen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Panen  $panen
     * @return \Illuminate\Http\Response
     */
    public function edit($kolamId, $siklusId, $panenId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $panen = $siklus->panen()->findOrFail($panenId);

        // dd($panen);

        return view('dashboard.tambak-udang.panen.edit', compact('kolam', 'siklus', 'panen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Panen  $panen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kolamId, $siklusId, $panenId)
    {
        $validation = $request->validate([
            'tanggal' => 'required|date',
            'waktu_panen' => 'required',
            'size_besar' => 'required|numeric',
            'size_kecil' => 'required|numeric',
            'tonase_besar' => 'required|numeric',
            'tonase_kecil' => 'required|numeric',
        ]);

        //Data yang diperlukan
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $panen = $siklus->panen()->findOrFail($panenId);

        //ABW
        $abw = 1000 / $validation['size_besar'];

        //Tonase Jumlah
        $tonaseJumlah = $validation['tonase_besar'] + $validation['tonase_kecil'];

        //POPULASI TERAMBIL
        $populasi = ($validation['tonase_besar'] * $validation['size_besar']) + ($validation['tonase_kecil'] * $validation['size_kecil']);

        //Update Data
        $panen->update([
            'tanggal' => $validation['tanggal'],
            'waktu_panen' => $validation['waktu_panen'],
            'size_besar' => $validation['size_besar'],
            'size_kecil' => $validation['size_kecil'],
            'tonase_besar' => $validation['tonase_besar'],
            'tonase_kecil' => $validation['tonase_kecil'],
            'tonase_jumlah' => $tonaseJumlah,
            'populasi_terambil' => $populasi,
            'abw' => $abw,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('panen.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data sampling berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Panen  $panen
     * @return \Illuminate\Http\Response
     */
    public function destroy($kolamId, $siklusId, $panenId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $panen = $siklus->panen()->findOrFail($panenId);

        $panen->delete();

        return redirect()->route('panen.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data berhasil dihapus');
    }
}
