<?php


use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthorBookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/books', [BookController::class, 'getBooksPaginate']);
Route::post('/books/{id}/rents', [RentController::class, 'create'])->middleware('auth:sanctum');
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
Route::get('/rents', [RentController::class, 'getMyRentsDatatable'])->middleware('auth:sanctum');
Route::get('/rents/my', [RentController::class, 'getMyRentsDatatable'])->middleware('auth:sanctum');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'admin']], function () {
    Route::get('/rents', [RentController::class, 'getAllRentsDatatable']);
    Route::put('/rents/{id}', [RentController::class, 'updateRentStatus']);
    Route::post('/books', [BookController::class, 'create']);
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);
    Route::post('/authors', [AuthorController::class, 'create']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);
});
