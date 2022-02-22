<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function getAllRentsDatatable()
    {

        $getData = Rent::with('user', 'book')->get();
        $datatable = DataTables::of($getData)->make(true);
        return $datatable;
    }

    public function getMyRentsDatatable()
    {

        $getData = Auth::user()->rents()->with('user', 'book')->get();
        $datatable = DataTables::of($getData)->make(true);
        return $datatable;
    }

    public function getMyRents()
    {

        $getData = Auth::user()->whereHas('rents', function ($q) {
            $q->where('status', 'IZNAJMLJENA');
        })->with('user', 'book')->get();
        $datatable = DataTables::of($getData)->make(true);
        return $datatable;
    }

    public function updateRentStatus($id, Request $request)
    {
        $rent = Rent::find($id);

        $rent->status = $request->input('status');

        if ($rent->save()) {

            $book = Book::find($rent->book_id);
            if ($request->input('status') == "IZNAJMLJENA") {

                $book->quantity -= 1;
            } else {

                $book->quantity += 1;
            }

            $book->save();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, Request $request)
    {
        $user = Auth::user();

        $book_id = $id;

        $userRents = $user->rents;
        if (count($userRents) > 3) {
            return response()->json(['message' => 'Vec imate preko 3 dozvoljene iznajmljene knjige. Vratite neku od tih kako biste uzeli novu.'], 403);
        }
        if (Rent::create(
            [
                'book_id' => $book_id,
                'user_id' => $user->id,
                'status' => 'IZNAJMLJENA'
            ]
        )) {
            return response()->json(['message' => 'Uspesno ste iznajmili knjigu. Imate pravo na ukupno 3 iznajmljene knjige.'], 200);
        }
        return response()->json(['message' => 'Doslo je do greske prilikom iznajmljivanja, kontaktirajte nas ako mislite da je greska.'], 500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show(Rent $rent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rent $rent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rent $rent)
    {
        //
    }
}
