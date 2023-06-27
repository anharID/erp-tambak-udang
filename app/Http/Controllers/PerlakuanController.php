<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use App\Models\Perlakuan;
use Illuminate\Http\Request;

class PerlakuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);

        $siklusTerpilih = $siklus->perlakuan()->where('kolam_id', $kolam->id)->orderBy('created_at', 'desc')->get();

        $siklusBerjalan = ($siklus->tanggal_selesai === null);
        return view('dashboard.tambak-udang.perlakuan.index', compact('kolam', 'siklus', 'siklusTerpilih', 'siklusBerjalan'));
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

        return view('dashboard.tambak-udang.perlakuan.create', compact('kolam', 'siklus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);

        $siklusSaatIni = $kolam->siklus()->where('kolam_id', $kolamId)->whereNull('tanggal_selesai')->first();

        $user = auth()->user();

        $validation = $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'required',
        ]);

        $perlakuan = new Perlakuan();
        $perlakuan->tanggal = $validation['tanggal'];
        $perlakuan->catatan = $validation['catatan'];
        $perlakuan->user()->associate($user);
        $perlakuan->siklus()->associate($siklusSaatIni);

        $kolam->perlakuan()->save($perlakuan);

        return redirect()->route('perlakuan.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data perlakuan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($kolamId, $siklusId, $perlakuanId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $perlakuan = $siklus->perlakuan()->findOrFail($perlakuanId);

        return view('dashboard.tambak-udang.perlakuan.edit', compact('kolam', 'siklus', 'perlakuan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Perlakuan  $perlakuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kolamId, $siklusId, $perlakuanId)
    {
        $validation = $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'required',
        ]);

        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $perlakuan = $siklus->perlakuan()->findOrFail($perlakuanId);

        $perlakuan->update([
            'tanggal' => $validation['tanggal'],
            'catatan' => $validation['catatan'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('perlakuan.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data perlakuan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perlakuan  $perlakuan
     * @return \Illuminate\Http\Response
     */
    public function destroy($kolamId, $siklusId, $perlakuanId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $perlakuan = $siklus->perlakuan()->findOrFail($perlakuanId);

        $perlakuan->delete();

        return redirect()->route('perlakuan.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data perlakuan berhasil dihapus.');
    }
}
