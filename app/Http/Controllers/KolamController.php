<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kolam;
use App\Models\Siklus;
use Illuminate\Http\Request;

class KolamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kolam = Kolam::all();
        $siklusAktif = Siklus::whereNull('tanggal_selesai')->first();

        if ($siklusAktif) {
            $doc = Carbon::now()->diffInDays($siklusAktif->tanggal_mulai);
        } else {
            $doc = null;
        }
        return view('dashboard.tambak-udang.kolam.index', compact('kolam', 'siklusAktif', 'doc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.tambak-udang.kolam.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'string', 'max:255'],
            'status' => ['required'],
            'luas' => ['required', 'numeric'],
            'kedalaman' => ['required', 'numeric'],
        ]);

        // Kolam::create($validation);
        Kolam::create([
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
            'tipe' => $request->tipe,
            'luas' => $request->luas,
            'kedalaman' => $request->kedalaman,
            'status' => $request->status,
            'catatan' => $request->catatan
        ]);

        return redirect()->route('kolam.index')->with('success', "Data berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kolam  $kolam
     * @return \Illuminate\Http\Response
     */
    public function show(Kolam $kolam)
    {

        // Ambil siklus berjalan saat ini
        $siklusSaatIni = null;

        return view('dashboard.tambak-udang.kolam.show', compact('kolam', 'siklusSaatIni'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kolam  $kolam
     * @return \Illuminate\Http\Response
     */
    public function edit(Kolam $kolam)
    {
        //
        return view('dashboard.tambak-udang.kolam.edit', compact('kolam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kolam  $kolam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kolam $kolam)
    {
        //
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'string', 'max:255'],
            'status' => ['required'],
            'luas' => ['required', 'numeric'],
            'kedalaman' => ['required', 'numeric'],
        ]);

        Kolam::where('id', $kolam->id)->update([
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
            'tipe' => $request->tipe,
            'status' => $request->status,
            'luas' => $request->luas,
            'kedalaman' => $request->kedalaman,
            'catatan' => $request->catatan
        ]);

        return redirect()->route('kolam.index')->with('success', "Data berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kolam  $kolam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kolam $kolam)
    {
        $kolam->delete();

        return redirect()->route('kolam.index')->with('success', "Kolam berhasil dihapus");
    }

    public function dataKolam(Kolam $kolam, $siklus)
    {
        // Ambil siklus berjalan saat ini
        $siklusSaatIni = $kolam->siklus()->whereNull('tanggal_selesai')->first();

        if ($siklusSaatIni) {
            // Perbarui DOC untuk siklus berjalan
            $siklusSaatIni->kolam()->updateExistingPivot($kolam->id, ['doc' => Carbon::now()->diffInDays($siklusSaatIni->tanggal_mulai)]);
        }

        // Ambil data siklus yang dipilih
        $siklusTerpilih = $kolam->siklus()->find($siklus);

        // Ambil siklus selesai
        $siklusSelesai = $kolam->siklus()->whereNotNull('tanggal_selesai')->orderBy('tanggal_mulai', 'desc')->get();

        //Menampilkan data terbaru ke detail kolam
        $monitoring = $siklusTerpilih->monitoring()->where('kolam_id', $kolam->id)->get();
        $pakan = $siklusTerpilih->pakan()->where('kolam_id', $kolam->id)->get();
        $jumlahPakanTerpakaiHariIni = $pakan->where('tanggal', Carbon::now()->toDateString())->sum('jumlah_kg');
        $sampling = $siklusTerpilih->sampling()->where('kolam_id', $kolam->id)->get();
        $perlakuan = $siklusTerpilih->perlakuan()->where('kolam_id', $kolam->id)->get();
        $panen = $siklusTerpilih->panen()->where('kolam_id', $kolam->id)->get();
        $energi = $siklusTerpilih->energi()->where('kolam_id', $kolam->id)->get();

        //kirim data
        $data = [
            'kolam' => $kolam,
            'siklusSaatIni' => $siklusSaatIni,
            'siklusTerpilih' => $siklusTerpilih,
            'siklusSelesai' => $siklusSelesai,
            'monitoring' => $monitoring,
            'pakan' => $pakan,
            'jumlahPakanTerpakaiHariIni' => $jumlahPakanTerpakaiHariIni,
            'sampling' => $sampling,
            'perlakuan' => $perlakuan,
            'panen' => $panen,
            'energi' => $energi,

        ];

        return view('dashboard.tambak-udang.kolam.show', $data);
    }
}
