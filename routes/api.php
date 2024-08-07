<?php

use App\Http\Controllers\BookController;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\BookResource;


Route::get('/books', function(){
    return BookResource::collection(Book::all());
});

Route::get('/book/{id}', function($id){
    return new BookResource(Book::findOrFail($id));
});

Route::post('/book', [BookController::class, 'store']);
Route::put('/book/{id}', [BookController::class, 'update']);
Route::delete('/book/{id}', [BookController::class, 'destroy']);




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


