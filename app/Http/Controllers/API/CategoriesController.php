<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use Validator;
use Auth;


class CategoriesController extends Controller
{
    public function index()
    {

        $categories = Categories::all();

        return response()->json([
            'message' => 'success',
            'data' => Categories::where('user_id', '=', Auth::id())->get()
        ], 200); 
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(
                [
                    'status' => false,
                    'message' => 'validation error',
                    $validator->errors()
                ],
                422);
            }

        $category = Categories::create([
            'name' => $request->input('name'),
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $category
        ], 200);
    }
}
