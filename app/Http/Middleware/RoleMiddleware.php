<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    { {
            $user = auth()->user();
            // dd($user->role);


            if ($user && in_array($user->role, $roles)) {
                return $next($request);
            }
            // dd($roles);

            abort(403); // Akses ditolak dengan respons 403 jika peran tidak memenuhi syarat
        }
    }
}
