<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NoteController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\SpotifyAuthController;
use App\Http\Controllers\WebPlaybackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('notes/create', [NoteController::class, 'create'])->name('create');
    Route::post('notes', [NoteController::class, 'store'])->name('notes.store');
});

//register
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');


// Routes for Spotify authentication
Route::get('/auth/login', [SpotifyAuthController::class, 'login'])->name('spotify.login');
Route::get('/auth/callback', [SpotifyAuthController::class, 'callback'])->name('spotify.callback');
Route::get('/auth/token', [SpotifyAuthController::class, 'token'])->name('spotify.token');

// Route for rendering the web playback view
Route::get('/webplayback', [WebPlaybackController::class, 'show'])->name('webplayback');

// Route for previous track action
Route::post('/webplayback/previous', [WebPlaybackController::class, 'previous'])->name('webplayback.previous');

// Route for toggle play/pause action
Route::post('/webplayback/toggle', [WebPlaybackController::class, 'toggle'])->name('webplayback.toggle');

// Route for next track action
Route::post('/webplayback/next', [WebPlaybackController::class, 'next'])->name('webplayback.next');


