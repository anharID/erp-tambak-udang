<?php

namespace App\Http\Controllers;

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
            'luas' => ['required', 'numeric', 'max:255'],
            'kedalaman' => ['required', 'numeric', 'max:255'],
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
        //
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
        //
        $kolam->delete();

        return redirect()->route('kolam.index')->with('success', "Kolam berhasil dihapus");
    }
}
