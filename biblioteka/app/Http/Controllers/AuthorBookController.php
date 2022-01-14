<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class AuthorBookController extends Controller
{
    public function index($author_id)
    {
        $books = Book::get()->where('author_id', $author_id);
        if (is_null($books))
            return response()->json('Data not found', 404);
        return response()->json($books);
    }
}
