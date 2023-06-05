<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kolam;
use App\Models\Sampling;
use Illuminate\Http\Request;

class SamplingController extends Controller
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

        $siklusTerpilih = $siklus->sampling()->orderBy('created_at', 'desc')->get();

        $siklusBerjalan = ($siklus->tanggal_selesai === null);

        return view('dashboard.tambak-udang.sampling.index', compact('kolam', 'siklus', 'siklusTerpilih', 'siklusBerjalan'));
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
        return view('dashboard.tambak-udang.sampling.create', compact('kolam', 'siklus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,  $kolamId, $siklusId)
    {
        $validation = $request->validate([
            'tanggal' => 'required|date',
            'berat' => 'required',
            'jumlah_udang' => 'required'
        ]);

        //Data yang diperlukan
        $kolam = Kolam::findOrFail($kolamId);
        $siklusSaatIni = $kolam->siklus()->whereNull('tanggal_selesai')->first();
        $user = auth()->user();
        $tanggalSebelumSampling = date('Y-m-d', strtotime('-1 day', strtotime($validation['tanggal'])));
        $pakan = $siklusSaatIni->pakan()->where('tanggal', $tanggalSebelumSampling)->get();
        $totalPakan = $pakan->sum('jumlah_kg');


        //UMUR
        $tanggalMulai = Carbon::parse($siklusSaatIni->tanggal_mulai);
        $tanggalSampling = Carbon::parse($validation['tanggal']);
        $umur = $tanggalMulai->diffInDays($tanggalSampling);

        //ABW
        $berat_sampling = $validation['berat'] / $validation['jumlah_udang'];

        $lastSampling = $siklusSaatIni->sampling()->latest()->first();

        //ADG
        if ($lastSampling) {
            $beratSebelumnya = $lastSampling->berat_sampling;
            $adg = ($berat_sampling - $beratSebelumnya) / 7;
        } else {
            $adg = $berat_sampling / $umur;
        }

        //SIZE
        $size = 1000 / $berat_sampling;

        //FR
        $feedingRate = pow(10, (-0.899 - 0.561 * log10($berat_sampling))) * 100;

        //BIOMASSA
        $biomassa = $totalPakan / $feedingRate * 100;

        //SR
        $totalTebar = $siklusSaatIni->total_tebar;
        $survivalRate = (($biomassa * $size) / $totalTebar) * 100;

        //Store Data
        $sampling = new Sampling();
        $sampling->tanggal = $validation['tanggal'];
        $sampling->umur = $umur;
        $sampling->berat_sampling = $berat_sampling;
        $sampling->adg = $adg;
        $sampling->size = $size;
        $sampling->sr = $survivalRate;
        $sampling->fr = $feedingRate;
        $sampling->biomas = $biomassa;
        $sampling->catatan = $request->catatan;

        $sampling->user()->associate($user);
        $sampling->siklus()->associate($siklusSaatIni);

        $kolam->sampling()->save($sampling);

        return redirect()->route('sampling.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data sampling berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sampling  $sampling
     * @return \Illuminate\Http\Response
     */
    public function show(Sampling $sampling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sampling  $sampling
     * @return \Illuminate\Http\Response
     */
    public function edit(Sampling $sampling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sampling  $sampling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sampling $sampling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sampling  $sampling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sampling $sampling)
    {
        //
    }
}
