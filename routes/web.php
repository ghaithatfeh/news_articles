<?php

use App\Http\Controllers\ArticleController;
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

Auth::routes();

Route::redirect('/', '/article');

Route::middleware('auth')->group(function () {
    Route::get('/article/my-article', [ArticleController::class, 'myArticle'])->name('article.my-article');
    Route::resource('/article', ArticleController::class);
});

Route::get('/article', [ArticleController::class, 'index'])->name('article.index');
Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article.show');

// Route::get('/article/create', [ArticleController::class, 'create'])->name('article.create');
// Route::post('/article', [ArticleController::class, 'store'])->name('article.store');
// Route::delete('/article/{article}', [ArticleController::class, 'destroy'])->name('article.delete');