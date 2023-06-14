<?php

namespace App\Http\Controllers;

use App\Models\Logistik;
use Illuminate\Http\Request;

class LogistikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logistik = Logistik::all();
        return view("dashboard.logistik.index", compact('logistik'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.logistik.create");
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
            'tanggal' => ['required', 'date'],
            'stok_masuk' => ['required', 'numeric'],
            'stok_keluar' => ['required', 'numeric'],
            'harga_satuan' => ['required', 'numeric'],
            'harga_total' => ['required', 'numeric'],
            'sumber' => ['required', 'string', 'max:100'],
        ]);

        Logistik::create([
            'tanggal' => $request->tanggal,
            'stok_masuk' => $request->stok_masuk,
            'stok_keluar' => $request->stok_keluar,
            'harga_satuan' => $request->harga_satuan,
            'harga_total' => $request->harga_total,
            'sumber' => $request->sumber,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('logistik.index')->with('success', "Data berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Logistik  $logistik
     * @return \Illuminate\Http\Response
     */
    public function show(Logistik $logistik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Logistik  $logistik
     * @return \Illuminate\Http\Response
     */
    public function edit(Logistik $logistik)
    {
        return view("dashboard.logistik.edit", compact('logistik'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Logistik  $logistik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logistik $logistik)
    {
        $request->validate([
            'tanggal' => ['required', 'date'],
            'stok_masuk' => ['required', 'numeric'],
            'stok_keluar' => ['required', 'numeric'],
            'harga_satuan' => ['required', 'numeric'],
            'harga_total' => ['required', 'numeric'],
            'sumber' => ['required', 'string', 'max:100'],
        ]);


        Logistik::where('id', $logistik->id)->update([
            'tanggal' => $request->tanggal,
            'stok_masuk' => $request->stok_masuk,
            'stok_keluar' => $request->stok_keluar,
            'harga_satuan' => $request->harga_satuan,
            'harga_total' => $request->harga_total,
            'sumber' => $request->sumber,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('logistik.index')->with('success', "Data berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logistik  $logistik
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logistik $logistik)
    {
        $logistik->delete();

        return redirect()->route('logistik.index')->with('success', "Data berhasil dihapus");
    }
}
