<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Finansial;
use App\Models\Siklus;
use App\Models\Logistik;
use Illuminate\Http\Request;

class LogistikController extends Controller
{
    public function index($inventaris)
    {
        $data_inventaris = Inventaris::find($inventaris);
        $logistik = $data_inventaris->logistik()->get();
        // dd($logistik);
        return view('dashboard.inventaris.logistik.index', compact('data_inventaris', 'logistik'));
    }

    public function create($inventaris)
    {
        $inventaris = Inventaris::find($inventaris);
        $siklus = Siklus::all();
        return view('dashboard.inventaris.logistik.create', compact('inventaris', 'siklus'));
    }

    public function store(Request $request, $inventaris)
    {
        $request->validate([
            'tanggal' => ['required', 'date'],
            'keterangan' => ['required', 'string'],
            'sumber' => ['required', 'string', 'max:100'],
        ]);

        $finansial = new Finansial();
        $item = Inventaris::find($inventaris);
        $stok_lama = $item->stok;

        if ($request->keterangan == 'stok_masuk') {
            $stok_baru = $stok_lama + $request->stok_masuk;
        } else {
            $stok_baru = $stok_lama - $request->stok_keluar;

            if ($stok_baru < 0) {
                return redirect()->route('logistik.create', $inventaris)->withErrors(['stok_keluar' => 'Stok keluar melebihi stok yang tersedia'])->withInput();
            }
        }

        $item->stok = $stok_baru;
        $item->nilai_inventaris = $item->harga_satuan * $stok_baru;
        $item->save();

        $logistik = Logistik::create([
            'siklus_id' => $request->siklus_id,
            'inventaris_id' => $inventaris,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'stok_masuk' => $request->stok_masuk,
            'stok_keluar' => $request->stok_keluar,
            'sumber' => $request->sumber,
            'catatan' => $request->catatan
        ]);

        // Finansial

        if ($request->input('keterangan') == 'stok_masuk') {
            $jenisTransaksi = 'Pengeluaran';
            $jumlahStok = $request->stok_masuk;
            $keterangan = "Stok Masuk - " . $item->nama_barang;
            $finansial->logistik_id = $logistik->id;
            $finansial->siklus_id = $request->siklus_id;
            $finansial->tanggal = $request->tanggal;
            $finansial->jenis_transaksi = $jenisTransaksi;
            $finansial->jumlah = $item->harga_satuan * $jumlahStok;
            $finansial->keterangan = $keterangan;
            $finansial->catatan = $request->catatan;
            $finansial->save();
        }

        return redirect()->route('logistik.index', $inventaris)->with('success', 'Data logistik berhasil ditambahkan');
    }

    public function show($inventaris, $logistik)
    {
    }

    public function edit($inventaris, $logistik)
    {
        $inventaris = Inventaris::find($inventaris);
        $logistik = Logistik::find($logistik);
        $siklus = Siklus::all();
        return view('dashboard.inventaris.logistik.edit', compact('inventaris', 'logistik', 'siklus'));
    }

    public function update(Request $request, $inventaris, $logistik)
    {
        $request->validate([
            'tanggal' => ['required', 'date'],
            'keterangan' => ['required', 'string'],
            'sumber' => ['required', 'string', 'max:100'],
        ]);

        $logistik = Logistik::find($logistik);

        $item = Inventaris::find($inventaris);
        $stok_inventaris = $item->stok;

        $stok_masuk_difference = ($request->stok_masuk ?? 0) - ($logistik->stok_masuk ?? 0);
        $stok_keluar_difference = ($request->stok_keluar ?? 0) - ($logistik->stok_keluar ?? 0);

        if ($request->stok_masuk !== null) {
            $stok_inventaris += $stok_masuk_difference;
        }
        if ($request->stok_keluar !== null) {
            $stok_inventaris -= $stok_keluar_difference;

            if ($stok_inventaris < 0) {
                return redirect()->route('logistik.edit', ['inventaris' => $inventaris, 'logistik' => $logistik])->withErrors(['stok_keluar' => 'Stok keluar melebihi stok yang tersedia'])->withInput();
            }
        }

        // Update the Inventaris stok
        $item->stok = $stok_inventaris;
        $item->nilai_inventaris = $item->harga_satuan * $stok_inventaris;
        $item->save();

        $logistik->update([
            'inventaris_id' => $inventaris,
            'siklus_id' => $request->siklus_id,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'stok_masuk' => $request->stok_masuk,
            'stok_keluar' => $request->stok_keluar,
            'sumber' => $request->sumber,
            'catatan' => $request->catatan
        ]);

        // Finansial
        $finansial = Finansial::where('logistik_id', $logistik->id)->first();
        if (!$finansial) {
            $finansial = new Finansial();
        };
        if ($request->input('keterangan') == 'stok_masuk') {
            $jenisTransaksi = 'Pengeluaran';
            $jumlahStok = $request->stok_masuk;
            $keterangan = "Stok Masuk - " . $item->nama_barang;
            $finansial->logistik_id = $logistik->id;
            $finansial->siklus_id = $request->siklus_id;
            $finansial->tanggal = $request->tanggal;
            $finansial->jenis_transaksi = $jenisTransaksi;
            $finansial->jumlah = $item->harga_satuan * $jumlahStok;
            $finansial->keterangan = $keterangan;
            $finansial->catatan = $request->catatan;
            $finansial->save();

        } elseif ($request->input('keterangan') == 'stok_keluar'){
            $finansial->delete();
        }

        return redirect()->route('logistik.index', $inventaris)->with('success', 'Data logistik berhasil diperbarui');
    }

    public function destroy($inventaris, $logistik)
    {
        $logistik = Logistik::find($logistik);
        $finansial = Finansial::where('logistik_id', $logistik->id)->first();
        if ($finansial) {
            $finansial->delete();
        }
        $logistik->delete();

        return redirect()->route('logistik.index', $inventaris)->with('success', 'Data logistik berhasil dihapus');
    }
}
