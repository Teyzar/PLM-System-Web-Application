<?php

use App\Http\Controllers\LinemanController;
use App\Http\Controllers\SearchController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UnitsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('/lineman', LinemanController::class);
Route::get('/search', [SearchController::class, 'search']);

Route::get('/units', [UnitsController::class, 'index'])->name('units');
