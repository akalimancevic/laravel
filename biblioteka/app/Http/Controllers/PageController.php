<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function booksPage()
    {

        return view('books');
    }

    public function rentedBooks()
    {

        return view('rented-books');
    }

    public function authorsPage()
    {

        return view('authors');
    }

    public function newAuthorPage()
    {

        return view('new-author');
    }
    
    public function newBookPage()
    {
        return view('new-book');
    }

    public function bookPage($id)
    {

        return view('book');
    }

    public function rentsPage()
    {

        return view('rents');
    }

    public function statisticsPage()
    {

        return view('statistics', ['rents' => Rent::all()]);
    }
}
