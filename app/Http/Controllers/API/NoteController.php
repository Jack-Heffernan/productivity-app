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

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note = Note::find($id);

        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        $note->title = $request->input('title');
        $note->content = $request->input('content');
        $note->save();

        return response()->json(['message' => 'Note updated successfully', 'data' => $note], 200);
    }

    public function destroy($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        $note->delete();

        return response()->json(['message' => 'Note deleted successfully'], 200);
    }

}

