<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books= Book::all();
        return new BookCollection($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:100',
            'description' => 'required|string|min:10',
            'author_id' => 'required'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

        $book = Book::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'author_id' => $request->author_id,
            'user_id' => Auth::user()->id, 
        ]);

        return response()->json(['Book is created successfully.', new BookResource($book)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($book)
    {
        $bk = Book::find($book);
        if (is_null($bk))
            return response()->json('Data not found', 404); 
        return response()->json($bk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:100',
            'description' => 'required|string|min:10',
            'author_id' => 'required'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

        
        $book->title = $request->title;
        $book->slug = $request->slug;
        $book->description = $request->description;
        $book->author_id = $request->author_id;

        $book->save();

        return response()->json(['Book is updated successfully.', new BookResource($book)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json('Book is deleted successfully.');
    }
}
