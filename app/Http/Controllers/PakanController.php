<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use App\Models\Pakan;
use Illuminate\Http\Request;

class PakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->where('id', $siklusId)->firstOrFail();

        $siklusTerpilih = $siklus->pakan()->orderBy('created_at', 'desc')->get();

        $siklusBerjalan = ($siklus->tanggal_selesai === null);

        return view('dashboard.tambak-udang.pakan.index', compact('kolam', 'siklus', 'siklusTerpilih', 'siklusBerjalan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->where('id', $siklusId)->firstOrFail();
        return view('dashboard.tambak-udang.pakan.create', compact('kolam', 'siklus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);

        $siklusSaatIni = $kolam->siklus()->whereNull('tanggal_selesai')->first();

        $user = auth()->user();

        $validation = $request->validate([
            'tanggal' => 'required|date',
            'waktu_pemberian' => 'required',
            'no_pakan' => 'required',
            'jumlah_kg' => 'required|numeric',
        ]);

        $pakan = new Pakan();
        $pakan->tanggal = $validation['tanggal'];
        $pakan->waktu_pemberian = $validation['waktu_pemberian'];
        $pakan->no_pakan = $validation['no_pakan'];
        $pakan->jumlah_kg = $validation['jumlah_kg'];
        $pakan->catatan = $request->catatan;

        // $pakan = $kolam->pakan()->create([
        //     'tanggal' => $validation['tanggal'],
        //     'waktu_pemberian' => $validation['waktu_pemberian'],
        //     'no_pakan' => $validation['no_pakan'],
        //     'jumlah_kg' => $validation['jumlah_kg'],
        //     'catatan' => $request->catatan

        // ]);

        $pakan->user()->associate($user);
        $pakan->siklus()->associate($siklusSaatIni);

        $kolam->pakan()->save($pakan);

        return redirect()->route('pakan.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data pakan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pakan  $pakan
     * @return \Illuminate\Http\Response
     */
    public function show(Pakan $pakan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pakan  $pakan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pakan $pakan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pakan  $pakan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pakan $pakan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pakan  $pakan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pakan $pakan)
    {
        //
    }
}
