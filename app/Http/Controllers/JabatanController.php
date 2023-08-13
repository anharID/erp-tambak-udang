<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan = Jabatan::all();
        return view("dashboard.karyawan.jabatan.index", compact('jabatan'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => ['required', 'string', 'max:255'],
            'gaji' => ['required', 'numeric', 'digits_between:1,11'],
            'bonus' => ['required', 'numeric', 'digits_between:1,3'],
        ]);

        Jabatan::create([
            'jabatan' => $request->jabatan,
            'gaji' => $request->gaji,
            'bonus' => $request->bonus,
        ]);

        return redirect()->route('jabatan.index')->with('success', "Data berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jabatan $jabatan)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $data = $request->validate([
            'jabatan' => ['required', 'string', 'max:255'],
            'gaji' => ['required', 'numeric', 'digits_between:1,11'],
            'bonus' => ['required', 'numeric', 'digits_between:1,3'],
        ]);

        $jabatan->update($data);

        return redirect()->route('jabatan.index')->with('success', "Data berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('success', "Data berhasil dihapus");
    }
}
