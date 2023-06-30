<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kolam;
use App\Models\Siklus;
use Illuminate\Http\Request;

class SiklusController extends Controller
{
    public function create()
    {
        $kolam = Kolam::where('status', true)->get();
        return view('dashboard.tambak-udang.kolam.addnewsiklus', compact('kolam'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'kolam_list' => 'required|array',
            'kolam_list.*' => 'exists:kolam,id', // Memastikan kolam yang dipilih tersedia dan memiliki status siap
            'jumlah_tebar' => 'required|array',
            'jumlah_tebar.*' => 'integer|min:0', // Memastikan jumlah tebar berupa bilangan bulat positif
        ]);


        $siklus = Siklus::create([
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'catatan' => $request->input('catatan'),
        ]);

        $kolamList = $request->input('kolam_list');
        $jumlahTebar = $request->input('jumlah_tebar');

        foreach ($kolamList as $kolamId) {
            $siklus->kolam()->attach($kolamId, [
                'jumlah_tebar' => $jumlahTebar[$kolamId],
            ]);
        }


        return redirect()->route('kolam.index')->with('success', "Siklus berhasil ditambahkan");
    }

    public function tutupSiklus($siklusId)
    {
        $siklus = Siklus::findOrFail($siklusId);

        // Cek apakah ada siklus yang sedang berjalan pada kolam
        $siklusBerjalan = $siklus->whereNull('tanggal_selesai')->first();

        if ($siklusBerjalan) {
            // Update tanggal selesai siklus menjadi tanggal saat ini
            $siklusBerjalan->tanggal_selesai = now();
            $siklusBerjalan->save();

            // Redirect ke halaman detail kolam
            return redirect()->route('kolam.index')->with('success', 'Siklus berhasil ditutup.');
        }
    }

    public function edit($siklusId)
    {
        $siklus = Siklus::findOrFail($siklusId);
        $kolam = Kolam::where('status', 1)->get();

        return view('dashboard.tambak-udang.kolam.editsiklus', compact('siklus', 'kolam'));
    }

    public function updateSiklus(Request $request, $siklusId)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'kolam_list' => 'required|array',
            'kolam_list.*' => 'exists:kolam,id', // Memastikan kolam yang dipilih tersedia
            'jumlah_tebar' => 'required|array',
            'jumlah_tebar.*' => 'required|integer|min:0', // Memastikan jumlah tebar berupa bilangan bulat positif
        ]);

        $siklus = Siklus::findOrFail($siklusId);
        $siklus->tanggal_mulai = $request->input('tanggal_mulai');
        $siklus->save();

        $kolamList = $request->input('kolam_list');
        $jumlahTebar = $request->input('jumlah_tebar');

        $siklus->kolam()->detach(); // Menghapus semua relasi kolam pada siklus

        foreach ($kolamList as $kolamId) {
            $siklus->kolam()->attach($kolamId, [
                'jumlah_tebar' => $jumlahTebar[$kolamId],
            ]);
        }

        // $tanggalMulai = Carbon::parse($request->tanggal_mulai);

        // if ($siklus->tanggal_selesai) {
        //     $docSaatIni = $tanggalMulai->diffInDays($siklus->tanggal_selesai);
        // } else {
        //     $tanggalSaatIni = Carbon::now();
        //     $docSaatIni = $tanggalMulai->diffInDays($tanggalSaatIni);
        // }

        // $siklus->update([
        //     'tanggal_mulai' => $request->tanggal_mulai,
        //     'total_tebar' => $request->total_tebar,
        //     'catatan' => $request->catatan,
        //     'doc' => $docSaatIni
        // ]);

        return redirect()->route('kolam.index')->with('success', "Siklus berhasil diubah");
    }

    public function destroy($siklusId)
    {
        $siklus = Siklus::findOrFail($siklusId);

        $siklus->kolam()->detach();

        $siklus->monitoring()->delete();
        $siklus->pakan()->delete();
        $siklus->sampling()->delete();
        $siklus->perlakuan()->delete();
        $siklus->panen()->delete();
        $siklus->energi()->delete();

        $siklus->delete();

        return redirect()->route('kolam.index')->with('success', 'Data siklus dan data yang terkait berhasil dihapus');
    }
}
