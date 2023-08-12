<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\KelolaJenisBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelolaJenisBarangController extends Controller
{
    public function index()
    {
        $kelolajenisbarang = KelolaJenisBarang::all();
        return view('dashboard.inventaris.kelolajenisbarang.index', compact('kelolajenisbarang'));
    }
    
    public function create()
    {
        $availableJenisBarang = KelolaJenisBarang::pluck('jenisbarang', 'jenisbarang')->toArray();
        return view('dashboard.inventaris.kelolajenisbarang.create', compact('availableJenisBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenisbarang' => ['required', 'string', 'max:100', 'unique:kelolajenisbarang'],
        ],
        [
            'jenisbarang.unique' => 'Data ini sudah ada.',
        ]);

        KelolaJenisBarang::create([
            'jenis_barang_id' => $request->jenis_barang_id,
            'jenisbarang' => $request->jenisbarang,
        ]);

        return redirect()->route('kelola_barang')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(KelolaJenisBarang $kelolajenisbarang)
    {
    }

    public function edit(KelolaJenisBarang $kelolajenisbarang)
    {
        $availableJenisBarang = KelolaJenisBarang::pluck('jenisbarang', 'jenisbarang')->toArray();
        return view('dashboard.inventaris.kelolajenisbarang.edit', compact('kelolajenisbarang', 'availableJenisBarang'));
    }

    public function update(Request $request, KelolaJenisBarang $kelolajenisbarang)
    {
        $request->validate([
            'jenisbarang' => ['required', 'string', 'max:100', Rule::unique('kelolajenisbarang')->ignore($kelolajenisbarang->id)],
        ],
        [
            'jenisbarang.unique' => 'Data ini sudah ada.',
        ]);

        DB::transaction(function () use ($request, $kelolajenisbarang) {
            $oldJenisBarang = $kelolajenisbarang->jenisbarang;
            $newJenisBarang = $request->jenisbarang;

            $kelolajenisbarang->update([
                'jenisbarang' => $newJenisBarang,
            ]);

            Inventaris::where('jenis_barang', $oldJenisBarang)
            ->update(['jenis_barang' => $newJenisBarang]);
        });

        return redirect()->route('kelola_barang')->with('success', "Data berhasil diperbarui");
    }

    public function destroy(KelolaJenisBarang $kelolajenisbarang)
    {
        $kelolajenisbarang->delete();

        return redirect()->route('kelola_barang')->with('success', 'Data berhasil dihapus');
    }
}

