<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kolam;
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
        return view('dashboard.tambak-udang.kolam.index', compact('kolam'));
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
        // $validation =  
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'string', 'max:255'],
            'luas' => ['required', 'numeric'],
            'kedalaman' => ['required', 'numeric'],
        ]);

        // Kolam::create($validation);
        Kolam::create([
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
            'tipe' => $request->tipe,
            'luas' => $request->luas,
            'kedalaman' => $request->kedalaman
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
            'luas' => ['required', 'numeric', 'max:255'],
            'kedalaman' => ['required', 'numeric', 'max:255'],
        ]);

        Kolam::where('id', $kolam->id)->update([
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
            'tipe' => $request->tipe,
            'luas' => $request->luas,
            'kedalaman' => $request->kedalaman
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
        // Ambil siklus selesai
        $siklusSelesai = $kolam->siklus()->whereNotNull('tanggal_selesai')->orderBy('tanggal_mulai', 'desc')->get();

        $siklusTerpilih = $kolam->siklus()->find($siklus);
        $monitoring = $siklusTerpilih->monitoring()->get();
        $pakan = $siklusTerpilih->pakan()->get();
        $jumlahPakanTerpakaiHariIni = $pakan->where('tanggal', Carbon::now()->toDateString())->sum('jumlah_kg');
        $sampling = $siklusTerpilih->sampling()->get();
        $perlakuan = $siklusTerpilih->perlakuan()->get();
        $panen = $siklusTerpilih->panen()->get();
        $energi = $siklusTerpilih->energi()->get();


        if ($siklusTerpilih == $siklusSaatIni) {
            // Ubah tanggal mulai menjadi objek Carbon
            $tanggalMulai = Carbon::parse($siklusSaatIni->tanggal_mulai);
            // Hitung DOC saat ini
            $tanggalSaatIni = Carbon::now();
            $docSaatIni = $tanggalMulai->diffInDays($tanggalSaatIni);
            //update ke tabel siklus
            $siklusSaatIni->update(['doc' => $docSaatIni]);
        }

        $data = [
            'kolam' => $kolam,
            'siklusSaatIni' => $siklusSaatIni,
            'siklusTerpilih' => $siklusTerpilih,
            'siklusSelesai' => $siklusSelesai,
            'siklusTerpilih' => $siklusTerpilih,
            'monitoring' => $monitoring,
            'pakan' => $pakan,
            'jumlahPakanTerpakaiHariIni' => $jumlahPakanTerpakaiHariIni,
            'sampling' => $sampling,
            'perlakuan' => $perlakuan,
            'panen' => $panen,
            'energi' => $energi,

        ];

        return view('dashboard.tambak-udang.kolam.show', $data);

        // return view('dashboard.tambak-udang.kolam.show', compact('kolam', 'siklusSaatIni'));
    }
}
