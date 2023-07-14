<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class DateRangeReporteMiddleware
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
        $startDate = Carbon::parse('2023-08-18 00:00:00');

        $currentDate = Carbon::now();
        if ($currentDate->gte($startDate)) {
            // La fecha actual está dentro del rango permitido
            return $next($request);
        }

        // La fecha actual está fuera del rango permitido
        return response()->json([
            "error"=>"acceso denegado, no es temporada para hacer esa acción"
        ],403);
    }
}
