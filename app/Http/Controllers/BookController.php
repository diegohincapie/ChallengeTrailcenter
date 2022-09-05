<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::leftJoin(
            'authors AS authors',
            'authors.id',
            '=',
            'books.author_id'
        )
        ->select(
            'books.id AS book_id',
            'books.name AS book_name',
            'books.year AS book_year',
            'authors.name AS author_name',
            'authors.genre AS author_genre'
        )->get();

        return response()->json($books, 200);
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

        if(!isset($params['author-name']) || !isset($params['author-birth']) || !isset($params['author-genre']) || !isset($params['book-name']) || !isset($params['book-year']) || !isset($params['library'])) {
            return response()->json([], 500);    
        }
        if(!BookController::validateDate($params['author-birth'])) {
            return response()->json([], 500);    
        }
        if(!ctype_digit($params['book-year']) || ($params['book-year']>date('Y'))) {
            return response()->json([], 500);    
        }

        $book = New Book();
        $author = Author::where('name', $params['author-name'])->first();

        if(!$author) {
            $author = new Author();
            $author -> name = $params['author-name'];
            $author -> birth_date = $params['author-birth'];
            $author -> genre = $params['author-genre'];
            $author -> save();
        }

        $book->author_id = $author->id;
        $book->name = $params['book-name'];
        $book->year = $params['book-year'];
        $book->save();

        $book->libraries()->attach($params['library']);

        return response()->json(['id' => $book->id], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $book->author = $book->author;
        $book->libraries = $book->libraries;

        return response()->json(['book' => $book], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $params = $request->all();

        if(!isset($params['author-name']) || !isset($params['author-birth']) || !isset($params['author-genre']) || !isset($params['book-name']) || !isset($params['book-year']) || !isset($params['library'])) {
            return response()->json([], 500);    
        }
        if(!BookController::validateDate($params['author-birth'])) {
            return response()->json([], 500);    
        }
        if(!ctype_digit($params['book-year']) || ($params['book-year']>date('Y'))) {
            return response()->json([], 500);    
        }

        $author = Author::where('name', $params['author-name'])->first();

        if(!$author) {
            $author = new Author();
            $author -> name = $params['author-name'];
            $author -> birth_date = $params['author-birth'];
            $author -> genre = $params['author-genre'];
            $author -> save();
        }

        $book->author_id = $author->id;
        $book->name = $params['book-name'];
        $book->year = $params['book-year'];
        $book->save();

        $book->libraries()->attach($params['library']);

        return response()->json(['id' => $book->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if(!$book) {
            return response()->json([], 404);    
        }

        $book->delete();

        return response()->json([], 200);
    }

    protected static function validateDate($date, $format = 'Y-m-d'){
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
