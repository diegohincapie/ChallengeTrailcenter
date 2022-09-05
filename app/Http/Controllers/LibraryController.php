<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $libraries = [];

        $ldb = Library::get();
        
        if(isset($params['book'])) {

            if(!ctype_digit($params['book'])) {
                return response()->json([], 500);        
            }

            $book = Book::find($request->get('book'));

            $librariesd = false;
            
            if($book) {
                $librariesd = $book->libraries();
            }

            $ldb = [];

            if($librariesd) {
                $ldb = $librariesd->get();
            }
        }

        foreach($ldb as $library) {
            $libraries[] = ['id' => $library->id, 'label' => $library->name, 'address' => $library->address];
        }

        return response()->json($libraries, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();

        if(!isset($params['name']) || !isset($params['address'])) {
            return response()->json([], 500);    
        }

        $library = new Library();
        $library -> name = $params['name'];
        $library -> address = $params['address'];
        $library -> save();

        return response()->json(['id' => $library->id], 200);
    }

    public function autocomplete(Request $request) {
        $params = $request->all();
        if((count($params)<1) || (!isset($params['term']))) {
            return response()->json([], 404);
        }

        $libraries = [];

        $ldb = Library::where('name', 'LIKE', '%'.$params['term'].'%')->get();

        foreach($ldb as $library) {
            $libraries[] = ['id' => $library->id, 'label' => $library->name, 'address' => $library->address];
        }

        return response()->json($libraries, 200);
    }
}
