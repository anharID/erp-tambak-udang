<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Pakan;
use App\Models\Panen;
use App\Models\Sampling;
use App\Models\Perlakuan;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class DataValidated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();
        $routeName = $route->getName();
        // dd($routeName);

        if ($routeName === 'monitoring.edit' || $routeName === 'monitoring.delete') {
            // Lakukan sesuatu untuk route dengan nama tertentu
            $idmonitoring = $request->route('monitoring');
            // $idsiklus = $request->route('siklus');
            // $idkolam = $request->route('kolamId');
            $monitoring = Monitoring::find($idmonitoring);
            if ($monitoring && $monitoring->is_validated == 1) {
                // return redirect()->route('panen.index', ['kolamId' => $idkolam, 'siklus' => $idsiklus])->with('error', 'Akses ditolak. Data sudah divalidasi.');
                abort(403);
            }
        }
        if ($routeName === 'pakan.edit' || $routeName === 'pakan.delete') {
            // Lakukan sesuatu untuk route dengan nama tertentu
            $idpakan = $request->route('pakan');
            // $idsiklus = $request->route('siklus');
            // $idkolam = $request->route('kolamId');
            $pakan = Pakan::find($idpakan);
            if ($pakan && $pakan->is_validated == 1) {
                // return redirect()->route('panen.index', ['kolamId' => $idkolam, 'siklus' => $idsiklus])->with('error', 'Akses ditolak. Data sudah divalidasi.');
                abort(403);
            }
        }
        if ($routeName === 'sampling.edit' || $routeName === 'sampling.delete') {
            // Lakukan sesuatu untuk route dengan nama tertentu
            $idsampling = $request->route('sampling');
            // $idsiklus = $request->route('siklus');
            // $idkolam = $request->route('kolamId');
            $sampling = sampling::find($idsampling);
            if ($sampling && $sampling->is_validated == 1) {
                // return redirect()->route('panen.index', ['kolamId' => $idkolam, 'siklus' => $idsiklus])->with('error', 'Akses ditolak. Data sudah divalidasi.');
                abort(403);
            }
        }
        if ($routeName === 'perlakuan.edit' || $routeName === 'perlakuan.delete') {
            // Lakukan sesuatu untuk route dengan nama tertentu
            $idperlakuan = $request->route('perlakuan');
            // $idsiklus = $request->route('siklus');
            // $idkolam = $request->route('kolamId');
            $perlakuan = Perlakuan::find($idperlakuan);
            if ($perlakuan && $perlakuan->is_validated == 1) {
                // return redirect()->route('panen.index', ['kolamId' => $idkolam, 'siklus' => $idsiklus])->with('error', 'Akses ditolak. Data sudah divalidasi.');
                abort(403);
            }
        }
        if ($routeName === 'panen.edit' || $routeName === 'panen.delete') {
            // Lakukan sesuatu untuk route dengan nama tertentu
            $idPanen = $request->route('panen');
            // $idsiklus = $request->route('siklus');
            // $idkolam = $request->route('kolamId');
            $panen = Panen::find($idPanen);
            if ($panen && $panen->is_validated == 1) {
                // return redirect()->route('panen.index', ['kolamId' => $idkolam, 'siklus' => $idsiklus])->with('error', 'Akses ditolak. Data sudah divalidasi.');
                abort(403);
            }
        }


        return $next($request);
    }
}
