<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route pour les sauces
Route::resource('/sauces', App\Http\Controllers\SauceController::class);
Route::post('/sauces/{sauce}/like', [App\Http\Controllers\SauceController::class, 'like'])->name('sauces.like');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/sauces', [App\Http\Controllers\SauceController::class, 'index'])->name('sauces.index');
    Route::get('/sauces/create', [App\Http\Controllers\SauceController::class, 'create'])->name('sauces.create');
    Route::post('/sauces', [App\Http\Controllers\SauceController::class, 'store'])->name('sauces.store');
    Route::get('/sauces/{sauce}', [App\Http\Controllers\SauceController::class, 'show'])->name('sauces.show');
    Route::get('/sauces/{sauce}/edit', [App\Http\Controllers\SauceController::class, 'edit'])->name('sauces.edit');
    Route::put('/sauces/{sauce}', [App\Http\Controllers\SauceController::class, 'update'])->name('sauces.update');
    Route::delete('/sauces/{sauce}', [App\Http\Controllers\SauceController::class, 'destroy'])->name('sauces.destroy');
    Route::post('/sauces/{sauce}/like', [App\Http\Controllers\SauceController::class, 'like'])->name('sauces.like');
});

Route::fallback(function () {
    abort(404);
});
