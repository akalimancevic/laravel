<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generatePDF(Rent $rent)
    {

        $rentData = $rent->load(['book.author', 'user']);

        $data = [
            'rent' => $rentData
        ];

        $pdf = PDF::loadView('pdf-invoice', $data);

        return $pdf->download($rentData->user->name . "_racun_" . $rentData->id  . ".pdf");
    }

    public function testPdf(Rent $rent)
    {

        $rentData = $rent->load(['book', 'user']);
        $data = [
            'rent' => $rentData
        ];
        return view('pdf-invoice', $data);
    }
}
