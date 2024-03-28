<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Note;
use Validator;
use Auth;

class NoteController extends Controller
{


    public function index()
    {

        $notes = Note::all();
        // dd(Note::where('user_id', '=', Auth::id())->get());

        return response()->json([
            'message' => 'success',
            'data' => Note::where('user_id', '=', Auth::id())->get()
        ], 200); 
    }

    public function create()
    {
        return view('create');
    }


    public function store(Request $request)
    {


        $validator = Validator::make($request->all(),
            [
                'title' => 'required|string|max:255',
                'content' => 'required|string'
            ]);


            if ($validator->fails()) {
                // create the JSON that will be returned in the response
                return response()->json(
                [
                    'status' => false,
                    'message' => 'validation error',
                    $validator->errors()
                ],
                // Have a look at all the Response codes in by ctrl click HTTP_UNPROCESSABLE_ENTITY below.
                422);
            }


        $note = Note::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Note created successfully', 'data' => $note], 201);
    }

    public function show ($id)
    {
        $note = Note::find($id);
        if (is_null($note)) {
            return response()->json(['message' => 'Note not found'], 404);
        }
        // else {
        //     // $note->load('notes');
        //     $statusMsg = 'success';
        //     $statusCode = 200;
        //   }
        return response()->json(['message' => 'Note found', 'data' => $note], 200);
    }

    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        if (is_null($note)) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        $validator = Validator::make($request->all(),
        [
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);


        if ($validator->fails()) {
            // create the JSON that will be returned in the response
            return response()->json(
            [
                'status' => false,
                'message' => 'validation error',
                $validator->errors()
            ],
            // Have a look at all the Response codes in by ctrl click HTTP_UNPROCESSABLE_ENTITY below.
            422);
        }

        $note->title = $request->input('title');
        $note->content = $request->input('content');
        $note->user_id = Auth::id();
        $note->save();

        // $note = Note::update([
        //     'title' => $request->input('title'),
        //     'content' => $request->input('content'),
        //     'user_id' => Auth::id(),
        // ]);

        // $note->update($request->all());
        return response()->json(['message' => 'Note updated successfully', 'data' => $note], 200);
    }

    public function destroy ($id)
    {
        $note = Note::findOrFail($id);
        if (is_null($note)) {
            return response()->json(['message' => 'Note not found'], 404);
        }
        elseif ($note->user_id != Auth::id()) {
            $note->delete();
            $statusMsg = 'Note deleted successfully';
            $statusCode = 200;
        }
        else{
            $statusMsg = 'Note:  {$id} not deleted';
            $statusCode = 422;
        }
        
        return response()->json(['message' => 'Note deleted successfully'], 200);
    }
}
