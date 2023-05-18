<?php

namespace App\Http\Controllers;

use App\Models\Siklus;
use Illuminate\Http\Request;

class SiklusController extends Controller
{
    public function create($kolamId)
    {
        //
        return view('dashboard.tambak-udang.kolam.addsiklus', compact('kolamId'));
    }

    public function addSiklus(Request $request, $kolamId){
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'total_tebar' => 'required',
            // tambahkan validasi lainnya sesuai kebutuhan

        ]);
        Siklus::create([
            'kolam_id' => $kolamId,
            'tanggal_mulai' => $request->tanggal_mulai,
            'total_tebar' => $request->total_tebar
        ]);

        return redirect()->route('kolam.show', ['kolam' => $kolamId])->with('success', "Siklus berhasil ditambahkan");
    }
}
