<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadsController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ProfilesController;

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

Route::controller(ThreadsController::class)->group(function () {
    Route::get('/threads', 'index');
    Route::get('/threads/create', 'create')->name('threads.create');
    Route::get('/threads/{channel}','index');
    Route::get('/threads/{channel}/{thread}', 'show');
    Route::delete('/threads/{channel}/{thread}', 'destroy');
    Route::post('/threads','store');
});

Route::controller(RepliesController::class)->group(function () {
    Route::post('/threads/{channel}/{thread}/replies', 'store');
    Route::delete('/replies/{reply}', 'destroy')->name('reply.destroy');
});

Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store'])->name('favorites.reply');
Route::get('/profiles/{user}', [ProfilesController::class, 'show'])->name('profile');
