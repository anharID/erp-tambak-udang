<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventaris = Inventaris::all();
        return view("dashboard.inventaris.index", compact('inventaris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.inventaris.create");
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
            'nama_barang' => ['required', 'string', 'max:100'],
            'jenis_barang' => ['required', 'string', 'max:100'],
            'tanggal_peroleh' => ['required', 'date'],
            'stok' => ['required', 'numeric'],
            'lokasi' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:100'],
        ]);

        Inventaris::create([
            'nama_barang' => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'tanggal_peroleh' => $request->tanggal_peroleh,
            'stok' => $request->stok,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('inventaris.index')->with('success', "Data berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function show(Inventaris $inventaris)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventaris $inventari)
    {
        return view("dashboard.inventaris.edit", compact('inventari'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventaris $inventari)
    {
        $request->validate([
            'nama_barang' => ['required', 'string', 'max:100'],
            'jenis_barang' => ['required', 'string', 'max:100'],
            'tanggal_peroleh' => ['required', 'date'],
            'stok' => ['required', 'numeric'],
            'lokasi' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:100'],
        ]);


        Inventaris::where('id', $inventari->id)->update([
            'nama_barang' => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'tanggal_peroleh' => $request->tanggal_peroleh,
            'stok' => $request->stok,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('inventaris.index')->with('success', "Data berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventaris $inventari)
    {
        $inventari->delete();

        return redirect()->route('inventaris.index')->with('success', "Data berhasil dihapus");
    }
}
