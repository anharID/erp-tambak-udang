<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Kolam;
use Illuminate\Http\Request;

class DetailKolam
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
        $routeName = $request->route()->getName();

        if ($routeName === 'kolam.show') {
            $routeKolam = $request->route('kolam');
            $idKolam = $routeKolam->id;
            $kolam = Kolam::find($idKolam);

            if ($kolam->siklus()->exists()) {
                $latestSiklusId = $kolam->siklus()->latest()->first()->id;

                return redirect()->route('data_kolam', ['kolam' => $idKolam, 'siklus' => $latestSiklusId]);
            }
        }
        return $next($request);
    }
}
