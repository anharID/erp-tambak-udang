<?php

namespace App\Http\Controllers;

use App\Models\Peralatan;
use Illuminate\Http\Request;

class PeralatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $peralatan = Peralatan::all();
        return view("dashboard.peralatan.index", compact('peralatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.peralatan.create");
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
            'nama_alat' => ['required', 'string', 'max:255'],
            'jumlah_alat' => ['required', 'numeric'],
            'kondisi_alat' => ['required', 'string', 'max:255'],
            'maintenance' => ['required', 'boolean'],
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        Karyawan::create([
            'nama_alat' => $request->nama_alat,
            'jumlah_alat' => $request->jumlah_alat,
            'kondisi_alat' => $request->kondisi_alat,
            'maintenance' => $request->maintenance,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('peralatan.index')->with('success', "Data berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Peralatan  $peralatan
     * @return \Illuminate\Http\Response
     */
    public function show(Peralatan $peralatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Peralatan  $peralatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Peralatan $peralatan)
    {
        return view("dashboard.peralatan.edit", compact('peralatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Peralatan  $peralatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peralatan $peralatan)
    {
        $request->validate([
            'nama_alat' => ['required', 'string', 'max:255'],
            'jumlah_alat' => ['required', 'numeric'],
            'kondisi_alat' => ['required', 'string', 'max:255'],
            'maintenance' => ['required', 'boolean'],
            'catatan' => ['required', 'string', 'max:255'],
        ]);


        Peralatan::where('id', $peralatan->id)->update([
            'nama_alat' => $request->nama_alat,
            'jumlah_alat' => $request->jumlah_alat,
            'kondisi_alat' => $request->kondisi_alat,
            'maintenance' => $request->maintenance,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('peralatan.index')->with('success', "Data berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peralatan  $peralatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peralatan $peralatan)
    {
        $peralatan->delete();

        return redirect()->route('peralatan.index')->with('success', "Data berhasil dihapus");
    }
}
