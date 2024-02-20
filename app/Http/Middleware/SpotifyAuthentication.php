<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SpotifyAuthentication
{
    public function handle(Request $request, Closure $next)
    {

        if (!$request->session()->has('spotify_access_token')) {

            return redirect()->route('spotify.login');
        }


        return $next($request);
    }
}
