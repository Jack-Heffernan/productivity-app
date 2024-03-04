<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Validator;
use Auth;

class NoteController extends Controller
{


    public function index()
    {

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
}
