<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function autocomplete(Request $request) {
        $authors = [];

        $params = $request->all();
        if((count($params)<1) || (!isset($params['term']))) {
            return response()->json([], 404);
        }

        $adb = Author::where('name', 'LIKE', '%'.$params['term'].'%')->get();

        foreach($adb as $author) {
            $authors[] = ['label' => $author->name, 'date' => $author->birth_date];
        }

        return response()->json($authors, 200);
    }
}
