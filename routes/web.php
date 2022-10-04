<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadsController;
use App\Http\Controllers\RepliesController;

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

Route::get('/threads', [ThreadsController::class, 'index']);
Route::get('/threads/{thread}', [ThreadsController::class, 'show']);
Route::post('/threads/{thread}/replies', [RepliesController::class, 'store']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
