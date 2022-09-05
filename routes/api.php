<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\AuthorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/authors/autocomplete', [AuthorController::class, 'autocomplete'])->name('aautocomplete');

Route::get('/libraries/autocomplete', [LibraryController::class, 'autocomplete'])->name('lautocomplete');

Route::apiResources([
    'books' => BookController::class,
    'libraries' => LibraryController::class
]);
