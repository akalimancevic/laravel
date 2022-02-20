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

        return view('statistics', [ 'rents' => Rent::all()]);
    }
}
