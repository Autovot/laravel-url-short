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


Route::get('/tdash', [UrlController::class, 'urlTableData']);


// URL
Route::get(
    '/{smashed}',
    [UrlController::class, 'incrementUsed']
)->name('url');
