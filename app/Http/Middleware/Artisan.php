<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Artisan
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role === 'artisan') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Only artisan accounts can access this area.');
    }
}
