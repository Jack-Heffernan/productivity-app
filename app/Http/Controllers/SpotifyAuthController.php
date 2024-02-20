<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SpotifyAuthController extends Controller
{
    public function login()
    {
        $scope = "streaming user-read-email user-read-private";
        $state = Str::random(16);

        $authUrl = 'https://accounts.spotify.com/authorize/?' . http_build_query([
            'response_type' => 'code',
            'client_id' => config('services.spotify.client_id'),
            'scope' => $scope,
            'redirect_uri' => config('services.spotify.redirect_uri'),
            'state' => $state,
        ]);

        return redirect()->away($authUrl);
    }

    public function callback(Request $request)
    {

        $code = $request->code;

        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => config('services.spotify.redirect_uri'),
            'client_id' => config('services.spotify.client_id'),
            'client_secret' => config('services.spotify.client_secret'),
        ]);

        if ($response->successful()) {
            $access_token = $response->json('access_token');

            session(['spotify_access_token' => $access_token]);

            return redirect()->route('webplayback')->with('success', 'Authenticated successfully.');
        } else {
            return redirect()->route('/')->with('error', 'Authentication failed.');
        }
    }

    public function token()
    {
        $access_token = session('spotify_access_token');
        
        if ($access_token) {
            return response()->json(['access_token' => $access_token]);
        } else {
            return response()->json(['error' => 'Access token not found.'], 404);
        }
    }
}


