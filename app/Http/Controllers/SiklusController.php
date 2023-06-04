<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

    public function tambahSiklus(Request $request, $kolamId)
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

    public function edit($kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);

        return view('dashboard.tambak-udang.kolam.editsiklus', compact('kolam', 'siklus'));
    }

    public function updateSiklus(Request $request, $kolamId, $siklusId)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'total_tebar' => 'required',
        ]);

        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);

        $tanggalMulai = Carbon::parse($request->tanggal_mulai);

        if ($siklus->tanggal_selesai) {
            $docSaatIni = $tanggalMulai->diffInDays($siklus->tanggal_selesai);
        } else {
            $tanggalSaatIni = Carbon::now();
            $docSaatIni = $tanggalMulai->diffInDays($tanggalSaatIni);
        }

        $siklus->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'total_tebar' => $request->total_tebar,
            'catatan' => $request->catatan,
            'doc' => $docSaatIni
        ]);
        return redirect()->route('data_kolam', ['kolam' => $kolam->id, 'siklus' => $siklus->id])->with('success', 'Data siklus berhasil diperbarui');
    }

    public function destroy($kolamId, $siklusId)
    {
        $kolam = Kolam::findOrFail($kolamId);
        $siklus = $kolam->siklus()->findOrFail($siklusId);

        $siklus->monitoring()->delete();

        $siklus->delete();

        $idSiklusTerkait = $kolam->siklus()->pluck('id')->last();

        if ($kolam->siklus->count() > 0) {
            return redirect()->route('data_kolam', ['kolam' => $kolam->id, 'siklus' => $idSiklusTerkait])->with('success', 'Data siklus berhasil dihapus');
        } else {
            return redirect()->route('kolam.show', $kolam->id)->with('success', 'Data siklus berhasil dihapus');
        }
    }
}
