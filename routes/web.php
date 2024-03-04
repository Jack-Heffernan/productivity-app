<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NoteController;

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
    return view('welcome');
});

// Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
// Route::post('login', [AuthController::class, 'login']);

// Route::middleware(['auth'])->group(function () {
//     Route::get('notes/create', [NoteController::class, 'create'])->name('create');
//     Route::post('notes', [NoteController::class, 'store'])->name('notes.store');
// });


