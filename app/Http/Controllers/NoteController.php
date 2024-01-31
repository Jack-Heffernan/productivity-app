<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    public function create()
{
    return view('create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'user_id' => 'required|exists:users,id',
    ]);

    Note::create([
        'title' => $request->input('title'),
        'content' => $request->input('content'),
        'user_id' => $request->input('user_id'),
    ]);

    return redirect()->route('create')->with('success', 'Note created successfully!');
}
}
