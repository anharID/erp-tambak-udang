<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\KelolaJenisBarang;
use App\Models\Logistik;
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
        //
        $inventaris = Inventaris::with('logistik')->get();
        return view('dashboard.inventaris.index', compact('inventaris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $kelolajenisbarang = KelolaJenisBarang::all();
        return view('dashboard.inventaris.create', compact('kelolajenisbarang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // $validation =  
        $validation = $request->validate([
            'nama_barang' => ['required', 'string', 'max:100'],
            'jenisbarang_id' => 'required',
            'tanggal_peroleh' => ['required', 'date'],
            'stok' => ['required', 'numeric'],
            'lokasi' => ['required', 'string', 'max:100'],
        ]);

        // Inventaris::create($validation);
        Inventaris::create([
            'nama_barang' => $request->nama_barang,
            'jenisbarang_id' => $request->jenisbarang_id,
            'tanggal_peroleh' => $request->tanggal_peroleh,
            'stok' => $request->stok,
            'harga_satuan' => $request->harga_satuan,
            'nilai_inventaris' => $request->stok * $request->harga_satuan,
            'lokasi' => $request->lokasi,
	        'status' => $request->status,
	        'catatan' => $request->catatan
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventari = Inventaris::find($id);
        $kelolajenisbarang = KelolaJenisBarang::all();
        return view('dashboard.inventaris.edit', compact('inventari', 'kelolajenisbarang'));
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
        //
        $validation = $request->validate([
            'nama_barang' => ['required', 'string', 'max:100'],
            'jenisbarang_id' => 'required',
            'tanggal_peroleh' => ['required', 'date'],
            'stok' => ['required', 'numeric'],
            'lokasi' => ['required', 'string', 'max:100'],
        ]);

        Inventaris::where('id', $inventari->id)->update([
            'nama_barang' => $request->nama_barang,
            'jenisbarang_id' => $request->jenisbarang_id,
            'tanggal_peroleh' => $request->tanggal_peroleh,
            'stok' => $request->stok,
            'harga_satuan' => $request->harga_satuan,
            'nilai_inventaris' => $request->stok * $request->harga_satuan,
            'lokasi' => $request->lokasi,
	        'status' => $request->status,
	        'catatan' => $request->catatan
        ]);

        return redirect()->route('inventaris.index')->with('success', "Data berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventaris $inventari)
    {
        $data_logistik = $inventari->logistik()->get();
        $data_logistik->each->delete();
        $inventari->delete();

        return redirect()->route('inventaris.index')->with('success', "Data inventaris berhasil dihapus");
    }
}
