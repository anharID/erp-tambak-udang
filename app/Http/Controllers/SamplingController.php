<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kolam;
use App\Models\Sampling;
use Illuminate\Http\Request;

class SamplingController extends Controller
{
    public function __construct()
    {
        // Middleware akan diterapkan hanya pada rute edit dan destroy
        $this->middleware('validated.data')->only(['edit', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);

        $siklusTerpilih = $siklus->sampling()->where('kolam_id', $kolam->id)->orderBy('created_at', 'desc')->get();

        $siklusBerjalan = ($siklus->tanggal_selesai === null);

        $chartData = $siklusTerpilih->sortBy('tanggal')->groupby(function ($item) {
            return Carbon::parse($item->tanggal)->format('j M o');
        })->map(function ($group)  {
            return $group->first();});

        return view('dashboard.tambak-udang.sampling.index', compact('kolam', 'siklus', 'siklusTerpilih', 'siklusBerjalan', 'chartData'));
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
            'berat_sampling' => 'required',
            'banyak_sampling' => 'required'
        ]);

        //Data yang diperlukan
        $kolam = Kolam::findOrFail($kolamId);
        $siklusSaatIni = $kolam->siklus()->findOrFail($siklusId);
        // $user = auth()->user();
        $tanggalSebelumSampling = date('Y-m-d', strtotime('-1 day', strtotime($validation['tanggal'])));
        $pakanKemarin = $siklusSaatIni->pakan()->where('kolam_id', $kolamId)->where('tanggal', $tanggalSebelumSampling)->get();
        $totalPakan = $pakanKemarin->sum('jumlah_kg');
        $pakanKomulatif = $siklusSaatIni->pakan()->where('kolam_id', $kolamId)->where('tanggal', '<', now()->subDay())->sum('jumlah_kg');


        //UMUR
        $tanggalMulai = Carbon::parse($siklusSaatIni->tanggal_mulai);
        $tanggalSampling = Carbon::parse($validation['tanggal']);
        $umur = $tanggalMulai->diffInDays($tanggalSampling);

        //ABW
        $abw = $validation['berat_sampling'] / $validation['banyak_sampling'];

        //ADG
        $lastSampling = $siklusSaatIni->sampling()->where('kolam_id', $kolam->id)->latest()->first();
        if ($lastSampling) {
            $abwSebelumnya = $lastSampling->abw;
            $adg = ($abw - $abwSebelumnya) / 7;
        } else {
            $adg = $abw / $umur;
        }

        //SIZE
        $size = 1000 / $abw;

        //FR
        $feedingRate = pow(10, (-0.899 - 0.561 * log10($abw))) * 100;

        //BIOMASSA
        $biomassa = $totalPakan / $feedingRate * 100;

        //SR
        $totalTebar = $siklusSaatIni->pivot->jumlah_tebar;
        // dd($totalTebar);
        $survivalRate = (($biomassa * $size) / $totalTebar) * 100;

        //FCR
        $fcr = $pakanKomulatif / $biomassa;

        //Store Data
        $sampling = new Sampling();
        $sampling->tanggal = $validation['tanggal'];
        $sampling->berat_sampling = $validation['berat_sampling'];
        $sampling->banyak_sampling = $validation['banyak_sampling'];
        $sampling->umur = $umur;
        $sampling->abw = $abw;
        $sampling->adg = $adg;
        $sampling->size = $size;
        $sampling->sr = $survivalRate;
        $sampling->fr = $feedingRate;
        $sampling->biomas = $biomassa;
        $sampling->fcr = $fcr;
        $sampling->catatan = $request->catatan;

        // $sampling->user()->associate($user);
        $sampling->siklus()->associate($siklusSaatIni);

        $kolam->sampling()->save($sampling);

        return redirect()->route('sampling.index', ['kolamId' => $kolamId, 'siklus' => $siklusId, 'chart' => 'abw'])->with('success', 'Data sampling berhasil disimpan.');
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
    public function edit($kolamId, $siklusId, $samplingId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $sampling = $siklus->sampling()->findOrFail($samplingId);

        return view('dashboard.tambak-udang.sampling.edit', compact('kolam', 'siklus', 'sampling'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kolamId, $siklusId, $samplingId)
    {
        $validation = $request->validate([
            'tanggal' => 'required|date',
            'berat_sampling' => 'required',
            'banyak_sampling' => 'required'
        ]);

        //Data yang diperlukan
        $kolam = Kolam::findOrFail($kolamId);
        $siklusSaatIni = $kolam->siklus()->findOrFail($siklusId);
        // dd($siklusSaatIni);
        $sampling = $siklusSaatIni->sampling()->findOrFail($samplingId);

        // $user = auth()->user();
        $tanggalSebelumSampling = date('Y-m-d', strtotime('-1 day', strtotime($validation['tanggal'])));
        $pakanKemarin = $siklusSaatIni->pakan()->where('kolam_id', $kolamId)->where('tanggal', $tanggalSebelumSampling)->get();
        $totalPakan = $pakanKemarin->sum('jumlah_kg');
        $pakanKomulatif = $siklusSaatIni->pakan->where('kolam_id', $kolamId)()->where('tanggal', '<', now()->subDay())->sum('jumlah_kg');


        //UMUR
        $tanggalMulai = Carbon::parse($siklusSaatIni->tanggal_mulai);
        $tanggalSampling = Carbon::parse($validation['tanggal']);
        $umur = $tanggalMulai->diffInDays($tanggalSampling);

        //ABW
        $abw = $validation['berat_sampling'] / $validation['banyak_sampling'];

        //ADG
        $lastSampling = $siklusSaatIni->sampling()->where('id', '<', $samplingId)->latest()->first();
        if ($lastSampling) {
            $abwSebelumnya = $lastSampling->abw;
            $adg = ($abw - $abwSebelumnya) / 7;
        } else {
            $adg = $abw / $umur;
        }

        //SIZE
        $size = 1000 / $abw;

        //FR
        $feedingRate = pow(10, (-0.899 - 0.561 * log10($abw))) * 100;

        //BIOMASSA
        $biomassa = $totalPakan / $feedingRate * 100;

        //SR
        $totalTebar = $siklusSaatIni->pivot->jumlah_tebar;
        $survivalRate = (($biomassa * $size) / $totalTebar) * 100;

        //FCR
        $fcr = $pakanKomulatif / $biomassa;

        //Update Data
        $sampling->update([
            'tanggal' => $validation['tanggal'],
            'berat_sampling' => $validation['berat_sampling'],
            'banyak_sampling' => $validation['banyak_sampling'],
            'umur' => $umur,
            'abw' => $abw,
            'adg' => $adg,
            'size' => $size,
            'fr' => $feedingRate,
            'sr' => $survivalRate,
            'biomas' => $biomassa,
            'fcr' => $fcr,
            'catatan' => $request->catatan
        ]);

        return redirect()->route('sampling.index', ['kolamId' => $kolamId, 'siklus' => $siklusId, 'chart' => 'abw'])->with('success', 'Data sampling berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($kolamId, $siklusId, $samplingId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $sampling = $siklus->sampling()->findOrFail($samplingId);

        $sampling->delete();

        return redirect()->route('sampling.index', ['kolamId' => $kolamId, 'siklus' => $siklusId, 'chart' => 'abw'])->with('success', 'Data sampling berhasil dihapus.');
    }

    public function dataValidated($kolamId, $siklusId, $samplingId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $sampling = $siklus->sampling()->findOrFail($samplingId);

        $sampling->is_validated = 1;
        $sampling->save();

        return redirect()->route('sampling.index', ['kolamId' => $kolamId, 'siklus' => $siklusId, 'chart' => 'abw'])->with('success', 'Data berhasil divalidasi');
    }
}
