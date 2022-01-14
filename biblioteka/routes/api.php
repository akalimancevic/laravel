<?php

/*
use App\Http\Controllers\API\AuthController;


*/
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthorBookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
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

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{id}', [AuthorController::class, 'show'])->name('authors.show');
Route::resource('authors.books', AuthorBookController::class)->only(['index']); 
/*Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function () { //grupna ruta, ovde je to tri, mozemo jedno isto pravilo da upotrebimo na vise ruta, to pravilo je ovo ogranicenje middleware=>sanctum koje kaze da ne mogu da pristupim rutama ukoliko nisam autorizovan
    Route::get('/profile', function (Request $request) {
        return auth()->user(); //vraca autentifikovanog user-a
    });

    Route::resource('posts', PostController::class)->only(['update', 'store', 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});*/
Route::resource('books', BookController::class)->only(['index']);
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');