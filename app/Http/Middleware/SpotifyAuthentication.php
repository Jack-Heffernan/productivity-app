<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SpotifyAuthentication
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated with Spotify
        if (!$request->session()->has('spotify_access_token')) {
            // Redirect the user to Spotify login
            return redirect()->route('spotify.login');
        }

        return $next($request);
    }
}
