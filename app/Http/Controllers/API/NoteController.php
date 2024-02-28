<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

    $note = Note::create([
        'title' => $request->input('title'),
        'content' => $request->input('content'),
        'user_id' => $request->input('user_id'),
    ]);

    return response()->json(['message' => 'Note created successfully', 'data' => $note], 201);
}

public function show($id)
{
    $note = Note::find($id);

    if (!$note) {
        return response()->json(['message' => 'Note not found'], 404);
    }

    return response()->json(['message' => 'Note retrieved successfully', 'data' => $note], 200);
}

public function index()
{
    $notes = Note::all();
    return response()->json($notes);
}

}

