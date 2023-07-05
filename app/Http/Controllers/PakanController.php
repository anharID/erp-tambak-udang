<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use App\Models\Pakan;
use App\Models\Siklus;
use App\Models\Logistik;
use App\Models\Inventaris;
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
        // dd($siklusId);
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $siklusBerjalan = ($siklus->tanggal_selesai === null);

        $dataPakan = $siklus->pakan()->where('kolam_id', $kolamId)->orderBy('created_at', 'desc')->get();

        $ringkasan = $siklus->pakan()->where('kolam_id', $kolamId)
            ->selectRaw('tanggal, SUM(jumlah_kg) as total_pakan')
            ->groupBy('tanggal')
            // ->orderBy('tanggal', 'desc')
            ->get();

        $totalPakanKumulatif = 0;
        foreach ($ringkasan as $row) {
            $totalPakanKumulatif += $row->total_pakan;
            $row->total_pakan_kumulatif = $totalPakanKumulatif;
        }



        return view('dashboard.tambak-udang.pakan.index', compact('kolam', 'siklus', 'dataPakan', 'siklusBerjalan', 'ringkasan', 'totalPakanKumulatif'));
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

        $inventaris = Inventaris::where('jenis_barang', 'Pakan')->get();

        return view('dashboard.tambak-udang.pakan.create', compact('kolam', 'siklus', 'inventaris'));
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

        $inventaris = Inventaris::where('nama_barang', $request->no_pakan)->first();
        $stokAsal = $inventaris->stok;
        $updatedStok = $stokAsal - $request->jumlah_kg;
        $nilaiInventaris = $updatedStok * $inventaris->harga_satuan;

        Logistik::create([
            'inventaris_id' => $inventaris->id,
            'tanggal' => $request->tanggal,
            'keterangan' => 'stok_keluar',
            'stok_masuk' => null,
            'stok_keluar' => $request->jumlah_kg,
            'sumber' => 'Gudang Pakan',
            'catatan' => 'digunakan pada kolam ' . $kolam->nama,
        ]);

        $inventaris->update([
            'stok' => $updatedStok,
            'nilai_inventaris' => $nilaiInventaris
        ]);

        $pakan = new Pakan();
        $pakan->tanggal = $validation['tanggal'];
        $pakan->waktu_pemberian = $validation['waktu_pemberian'];
        $pakan->no_pakan = $validation['no_pakan'];
        $pakan->jumlah_kg = $validation['jumlah_kg'];
        $pakan->catatan = $request->catatan;

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
    public function edit($kolamId, $siklusId, $pakanId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $pakan = $siklus->pakan()->findOrFail($pakanId);

        $inventaris = Inventaris::where('jenis_barang', 'Pakan')->get();

        return view('dashboard.tambak-udang.pakan.edit', compact('kolam', 'siklus', 'pakan', 'inventaris'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kolamId, $siklusId, $pakanId)
    {
        $validation = $request->validate([
            'tanggal' => 'required|date',
            'waktu_pemberian' => 'required',
            'no_pakan' => 'required',
            'jumlah_kg' => 'required|numeric',
        ]);

        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $pakan = $siklus->pakan()->findOrFail($pakanId);

        $jenisPakanSebelum = $pakan->no_pakan;

        if ($request->no_pakan !== $jenisPakanSebelum) {
            $dtInventarisSebelum = Inventaris::where('nama_barang', $jenisPakanSebelum)->first();
            $stokAsal = $dtInventarisSebelum->stok;
            $updatedStok = $stokAsal + $pakan->jumlah_kg;
            $nilaiInventaris = $updatedStok * $dtInventarisSebelum->harga_satuan;

            $dtInventarisSebelum->update([
                'stok' => $updatedStok,
                'nilai_inventaris' => $nilaiInventaris
            ]);

            $dtLogsitikSebbelum = Logistik::where('inventaris_id', $dtInventarisSebelum->id)
                ->where('updated_at', $pakan->updated_at)->first();
            $dtLogsitikSebbelum->delete();

            $dtInventaris = Inventaris::where('nama_barang', $request->no_pakan)->first();
            $stokAsal = $dtInventaris->stok;
            $updatedStok = $stokAsal - $request->jumlah_kg;
            $nilaiInventaris = $updatedStok * $dtInventaris->harga_satuan;

            $dtInventaris->update([
                'stok' => $updatedStok,
                'nilai_inventaris' => $nilaiInventaris
            ]);

            Logistik::create([
                'inventaris_id' => $dtInventaris->id,
                'tanggal' => $request->tanggal,
                'keterangan' => 'stok_keluar',
                'stok_masuk' => null,
                'stok_keluar' => $request->jumlah_kg,
                'sumber' => 'Gudang Pakan',
                'catatan' => 'digunakan pada kolam ' . $kolam->nama,
            ]);
        } else {
            $dtInventaris = Inventaris::where('nama_barang', $jenisPakanSebelum)->first();
            $stokSaatIni = $dtInventaris->stok;
            $stokAsal = $stokSaatIni + $pakan->jumlah_kg;
            $updatedStok = $stokAsal - $request->jumlah_kg;
            $nilaiInventaris = $updatedStok * $dtInventaris->harga_satuan;

            $dtInventaris->update([
                'stok' => $updatedStok,
                'nilai_inventaris' => $nilaiInventaris
            ]);

            $dtLogistik = Logistik::where('inventaris_id', $dtInventaris->id)
                ->where('updated_at', $pakan->updated_at)->first();
            $dtLogistik->update([
                'stok_keluar' => $request->jumlah_kg
            ]);
        }


        $pakan->update([
            'tanggal' => $validation['tanggal'],
            'waktu_pemberian' => $validation['waktu_pemberian'],
            'no_pakan' => $validation['no_pakan'],
            'jumlah_kg' => $validation['jumlah_kg'],
            'catatan' => $request->catatan
        ]);

        return redirect()->route('pakan.index', ['kolamId' => $kolam->id, 'siklus' => $siklus->id])->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pakan  $pakan
     * @return \Illuminate\Http\Response
     */
    public function destroy($kolamId, $siklusId, $pakanId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);
        $pakan = $siklus->pakan()->findOrFail($pakanId);

        $dtInventaris = Inventaris::where('nama_barang', $pakan->no_pakan)->first();
        $stokAsal = $dtInventaris->stok;
        $updatedStok = $stokAsal + $pakan->jumlah_kg;
        $nilaiInventaris = $updatedStok * $dtInventaris->harga_satuan;

        $dtInventaris->update([
            'stok' => $updatedStok,
            'nilai_inventaris' => $nilaiInventaris
        ]);

        Logistik::where('inventaris_id', $dtInventaris->id)
            ->where('updated_at', $pakan->updated_at)->delete();

        $pakan->delete();


        return redirect()->route('pakan.index', ['kolamId' => $kolamId, 'siklus' => $siklusId])->with('success', 'Data berhasil dihapus');
    }
}
