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
        // $books= Book::with(['author', 'genre'])->paginate();
        // return new BookCollection($books);
    }

    public function getBooksPaginate(Request $request)
    {

        $builder = Book::query();
        $term = $request->query();


        $perPage = 24;

        if (!empty($term['genres'])) {
            $builder->whereIn('genre_id', $term['genres']);
        }

        if (!empty($term['authors'])) {
            $builder->whereIn('author_id', $term['authors']);
        }

        if (!empty($term['perPage'])) {
            $perPage = $term['perPage'];
        }

        $books = $builder->with(['genre', 'author'])->paginate($perPage);
        return response()->json(['books' => $books], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $book = Book::create($request->all());

        $path = null;
        if ($request->hasFile('book_image_path')) {
            $book_image_path = $request->file('book_image_path');
            $naziv = time() . '.' . $book_image_path->getClientOriginalExtension();

            $path = $book_image_path->storeAs('', $naziv, 'public');
        };

        $book->book_image_path = $path;
        $book->save();
        return response()->json(['message' => 'Knjiga uspesno napravljena'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

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

        if ($book->fill($request->input())->save()) {
            $path = null;
            if ($request->hasFile('book_image_path')) {
                $book_image_path = $request->file('book_image_path');
                $naziv = time() . '.' . $book_image_path->getClientOriginalExtension();

                $path = $book_image_path->storeAs('', $naziv, 'public');
            };

            $book->book_image_path = $path;
            $book->save();
            return response()->json(['message' => 'Knjiga uspesno izmenjena.'], 200);
        }
        return response()->json(['message' => 'Greska prilikom izmene.'], 200);
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

        return response()->json(['message' => 'Knjiga uspesno obrisana']);
    }
}
