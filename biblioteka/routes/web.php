<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/knjige', [PageController::class, 'booksPage']);
Route::get('/knjige/dodavanje', [PageController::class, 'newBookPage']);
Route::get('/knjige/iznajmljene', [PageController::class, 'rentedBooks']);

Route::get('/autori', [PageController::class, 'authorsPage']);
Route::get('/autori/dodavanje', [PageController::class, 'newAuthorPage']);

Route::get('/iznajmljivanja', [PageController::class, 'rentsPage']);
Route::get('/statistika', [PageController::class, 'statisticsPage']);
Route::get('rents/{rent}/pdf', [PdfController::class, 'generatePDF']);