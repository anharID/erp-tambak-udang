<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use App\Models\Siklus;
use Illuminate\Http\Request;

class SiklusController extends Controller
{
    public function create($kolamId)
    {
        //
        return view('dashboard.tambak-udang.kolam.addsiklus', compact('kolamId'));
    }

    public function addSiklus(Request $request, $kolamId)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'total_tebar' => 'required',
            // tambahkan validasi lainnya sesuai kebutuhan

        ]);
        $newSiklus = Siklus::create([
            'kolam_id' => $kolamId,
            'tanggal_mulai' => $request->tanggal_mulai,
            'total_tebar' => $request->total_tebar,
            'catatan' => $request->catatan
        ]);
        $siklusId = $newSiklus->id;


        return redirect()->route('data_kolam', ['kolam' => $kolamId, 'siklus' => $siklusId])->with('success', "Siklus berhasil ditambahkan");
    }

    public function tutupSiklus($kolamId)
    {
        $kolam = Kolam::findOrFail($kolamId);

        // Cek apakah ada siklus yang sedang berjalan pada kolam
        $siklusBerjalan = $kolam->siklus->whereNull('tanggal_selesai')->first();

        if ($siklusBerjalan) {
            // Update tanggal selesai siklus menjadi tanggal saat ini
            $siklusBerjalan->tanggal_selesai = now();
            $siklusBerjalan->save();

            // Redirect ke halaman detail kolam
            return redirect()->route('data_kolam', ['kolam' => $kolamId, 'siklus' => $siklusBerjalan->id])->with('success', 'Siklus berhasil ditutup.');
        }
    }
}
