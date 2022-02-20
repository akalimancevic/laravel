<?php

use App\Http\Controllers\PageController;
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
Route::get('/knjiga/{id}', [PageController::class, 'bookPage']);

Route::get('/iznajmljivanja', [PageController::class, 'rentsPage']);
Route::get('/statistika', [PageController::class, 'statisticsPage']);


