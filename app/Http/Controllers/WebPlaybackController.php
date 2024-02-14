<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Middleware\SpotifyAuthentication;

class WebPlaybackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.spotify')->except('login');
    }

    public function show(Request $request)
    {

        $token = $request->session()->get('spotify_access_token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://api.spotify.com/v1/me/player');


        if ($response->successful()) {
            $data = $response->json();

            $current_track = [
                'name' => $data['item']['name'],
                'album' => [
                    'images' => [
                        ['url' => $data['item']['album']['images'][0]['url']]
                    ]
                ],
                'artists' => [
                    ['name' => $data['item']['artists'][0]['name']]
                ]
            ];

            $is_paused = $data['is_playing'] ? false : true;
            $is_active = true;
        } else {

            $current_track = null;
            $is_paused = true;
            $is_active = false;
        }

        return view('webplayback', compact('current_track', 'is_paused', 'is_active', 'token'));
    }

    public function previous(Request $request)
    {
        $token = $request->session()->get('spotify_access_token');


        Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('https://api.spotify.com/v1/me/player/previous');


        return back()->with('success', 'Previous track action executed successfully.');
    }

    public function toggle(Request $request)
    {

        $token = $request->session()->get('spotify_access_token');


        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://api.spotify.com/v1/me/player');


        if ($response->successful()) {
            $data = $response->json();


            $is_paused = $data['is_playing'] ? true : false;


            if ($is_paused) {

                Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                ])->put('https://api.spotify.com/v1/me/player/play');
            } else {

                Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                ])->put('https://api.spotify.com/v1/me/player/pause');
            }

            return back()->with('success', 'Toggle play/pause action executed successfully.');
        } else {

            return back()->with('error', 'Failed to toggle play/pause. Please try again.');
        }
    }

    public function next(Request $request)
    {

        $token = $request->session()->get('spotify_access_token');


        Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('https://api.spotify.com/v1/me/player/next');


        return back()->with('success', 'Next track action executed successfully.');
    }
}



