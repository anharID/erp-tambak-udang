<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kolam;
use App\Models\Siklus;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function export($siklusId)
    {
        $siklus = Siklus::findOrFail($siklusId);
        $kolam = $siklus->kolam()->get();

        // dd($kolam);

        $dataRekap = [];
        foreach ($kolam as $k) {
            // data monitoring
            $monitoringGroup = $k->monitoring()->where('siklus_id', $siklusId)->get()->groupBy('tanggal');
            $monitoringData = $k->monitoring()->where('siklus_id', $siklusId)->get();

            // data sampling
            $samplingData = $k->sampling()->where('siklus_id', $siklusId)->get();

            $lastADG = ($samplingData->last()->adg) ?? 0;

            // Data Pakan per Kolam
            $pakanPerKolam = $k->pakan()->where('siklus_id', $siklusId)->selectRaw('tanggal, SUM(jumlah_kg) as total_pakan')->groupBy('tanggal')->get();
            $totalPakanKumulatif = 0;
            foreach ($pakanPerKolam as $row) {
                $totalPakanKumulatif += $row->total_pakan;
                $row->total_pakan_kumulatif = $totalPakanKumulatif;
            }

            // Data pakan
            $pakanData = $k->pakan()->where('siklus_id', $siklusId)->get();

            // Data perlakuan
            $perlakuanData = $k->perlakuan()->where('siklus_id', $siklusId)->get();
            // dd($perlakuanData);

            //Data panen
            $panenData = $k->panen()->where('siklus_id', $siklusId)->get();

            $sr_raw = $panenData->sum('populasi_terambil') / $k->pivot->jumlah_tebar * 100;
            $sr = round($sr_raw, 2);

            if ($pakanData->sum('jumlah_kg') !== 0) {
                $fcr_raw = $panenData->sum('tonase_jumlah') / $pakanData->sum('jumlah_kg');
                $fcr = round($fcr_raw, 2);
            } else {
                $fcr = 0;
            }

            $dataRekap[] = [
                'kolam' => $k,
                'panen' => $panenData,
                'monitoring' => $monitoringGroup,
                'monitoringAll' => $monitoringData,
                'sampling' => $samplingData,
                'perlakuan' => $perlakuanData,
                'detailPakan' => $pakanPerKolam,
                'pakan' => $pakanData,
                'adg' => $lastADG,
                'sr' => $sr,
                'fcr' => $fcr,
            ];
        }

        $totalSR = 0;
        $totalFCR = 0;
        $totalADG = 0;
        $totalSuhu = 0;
        $totalPH = 0;
        $totalDO = 0;
        $totalSal = 0;

        $count = count($dataRekap);

        foreach ($dataRekap as $d) {
            $totalSR += $d['sr'];
            $totalFCR += $d['fcr'];
            $totalADG += $d['adg'];
            $totalSuhu += $d['monitoringAll']->avg('suhu');
            $totalPH += $d['monitoringAll']->avg('ph');
            $totalDO += $d['monitoringAll']->avg('do');
            $totalSal += $d['monitoringAll']->avg('salinitas');
        }

        $rataSR = ($count > 0) ? $totalSR / $count : 0;
        $rataFCR = ($count > 0) ? $totalFCR / $count : 0;
        $rataADG = ($count > 0) ? $totalADG / $count : 0;
        $rataSuhu = ($count > 0) ? $totalSuhu / $count : 0;
        $rataPH = ($count > 0) ? $totalPH / $count : 0;
        $rataDO = ($count > 0) ? $totalDO / $count : 0;
        $rataSal = ($count > 0) ? $totalSal / $count : 0;

        $data = [
            'siklus' => $siklus,
            'dataRekap' => $dataRekap,
            'rataSR' => $rataSR,
            'rataFCR' => $rataFCR,
            'rataADG' => $rataADG,
            'rataSuhu' => $rataSuhu,
            'rataPH' => $rataPH,
            'rataDO' => $rataDO,
            'rataSal' => $rataSal,
        ];


        $pdf = Pdf::loadView('dashboard.tambak-udang.reportpdf', $data);
        return $pdf->stream();
    }
}
