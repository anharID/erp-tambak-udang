<?php

namespace App\Http\Controllers;

use App\Models\KelolaJenisBarang;
use Illuminate\Http\Request;

class KelolaJenisBarangController extends Controller
{
    public function index()
    {
        $kelolajenisbarang = KelolaJenisBarang::all();
        return view('dashboard.inventaris.kelolajenisbarang.index', compact('kelolajenisbarang'));
    }
    
    public function create()
    {
        return view('dashboard.inventaris.kelolajenisbarang.create');
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'jenisbarang' => ['required', 'unique:kelolajenisbarang'],
        ],
        [
            'jenisbarang.unique' => 'Data ini sudah ada.',
        ]);

        KelolaJenisBarang::create([
            'jenisbarang' => $validation['jenisbarang']
        ]);

        return redirect()->route('kelola_barang')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($kelolajenisbarangId)
    {
        $kelolajenisbarang = KelolaJenisBarang::find($kelolajenisbarangId);

        return view('dashboard.inventaris.kelolajenisbarang.edit', compact('kelolajenisbarang'));
    }

    public function update(Request $request, $kelolajenisbarangId)
    {
        $validation = $request->validate([
            'jenisbarang' => ['required', 'unique:kelolajenisbarang'],
        ],
        [
            'jenisbarang.unique' => 'Data ini sudah ada.',
        ]);

        $kelolajenisbarang = KelolaJenisBarang::find($kelolajenisbarangId);

        $kelolajenisbarang->jenisbarang = $validation['jenisbarang'];
        $kelolajenisbarang->save();

        return redirect()->route('kelola_barang')->with('success', "Data berhasil diperbarui");
    }

    public function destroy($kelolajenisbarangId)
    {
        $kelolajenisbarang = KelolaJenisBarang::findOrFail($kelolajenisbarangId);
        $kelolajenisbarang->delete();

        return redirect()->route('kelola_barang')->with('success', 'Data berhasil dihapus');
    }
}

