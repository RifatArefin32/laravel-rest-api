<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    // Store a new book
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'pages' => 'required|integer',
        ]);

        if($validator->fails()){

            return response([
                'success' => false,
                'message' => $validator->errors(),
            ]);

            // return $this->sendError('Validation Error', $validator->errors());
        }
        
        $book = Book::create($input);
        return response([
            'success' => true,
            'message' => 'Book Record Created Successfully',
            'book' => $book
        ]);
    }

    /**
     * Display the specified resource.
     */
    // Get a single book
    public function show($id)
    {
        return Book::findOrFail($id);
    }

    // Update a book
    public function update(Request $request, $id)
    {
        if(Book::where('id', $id)->exists()){
            
            $book = Book::find($id);
            $input = $request->all();
            $validator = Validator::make($input, [
                'title' => 'sometimes|string|max:255',
                'author' => 'sometimes|string|max:255',
                'pages' => 'sometimes|integer',
            ]);

            if($validator->fails()){
                
                return response()->json([
                    'message' => $validator->errors(),
                ]);
            }

            $book->title = $request->title;
            $book->author = $request->author;
            $book->pages = $request->pages;
            $book->save();

            return response()->json([
                'message' => 'Book has been saved successfully',
                'status' => 200
            ]);
        }
        else{

            return response()->json([
                'message' => 'Update failed',
                'status' => 404
            ]);
        }
    }

    // Delete a book
    public function destroy($id)
    {
        if(Book::where('id', $id)->exists()){

            $book = Book::find($id);
            $book->delete();

            return response()->json([
                "message" => "Book deleted successfully",
                "status" => 200
            ]);
        }
        else{
            return response()->json([
                "message" => "Book not found",
                "status" => 404
            ]);
        }
    }
}
