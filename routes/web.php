<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main
Route::get('/', function () {
    return view('main');
})->name('main');

Route::get('/dash', function () {
    return view('dash');
})->name('dash');


// URL
Route::get(
    '/url/{smashed}',
    [UrlController::class, 'incrementUsed']
)->name('url');
