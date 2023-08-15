<?php

namespace App\Http\Controllers;

use App\Models\Energi;
use Illuminate\Http\Request;
use App\Models\PenggunaanEnergi;

class PenggunaanEnergiController extends Controller
{
    public function index()
    {
        $penggunaan = PenggunaanEnergi::all();

        return view('dashboard.tambak-udang.energi.penggunaan', compact('penggunaan'));
    }

    public function create()
    {
        return view('dashboard.tambak-udang.energi.addpenggunaan');
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'penggunaan' => 'required',
        ]);

        PenggunaanEnergi::create([
            'penggunaan' => $validation['penggunaan']
        ]);

        return redirect()->route('kategori_penggunaan')->with('success', 'Kategori penggunaan berhasil ditambahkan');
    }

    public function edit($penggunaanId)
    {
        $penggunaan = PenggunaanEnergi::findOrFail($penggunaanId);

        return view('dashboard.tambak-udang.energi.editpenggunaan', compact('penggunaan'));
    }

    public function update(Request $request, $penggunaanId)
    {
        $validation = $request->validate([
            'penggunaan' => 'required',
        ]);

        $penggunaan = PenggunaanEnergi::findOrFail($penggunaanId);

        $penggunaan->update([
            'penggunaan' => $validation['penggunaan']
        ]);

        return redirect()->route('kategori_penggunaan')->with('success', 'Kategori penggunaan berhasil ditambahkan');
    }

    public function destroy($penggunaanId)
    {
        $penggunaan = PenggunaanEnergi::findOrFail($penggunaanId);
        $energi = Energi::where('penggunaan_id', $penggunaanId)->get();

        foreach ($energi as $energiItem) {
            $energiItem->delete();
        }

        $penggunaan->delete();

        return redirect()->route('kategori_penggunaan')->with('success', 'Kategori penggunaan berhasil dihapus');
    }
}
