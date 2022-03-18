<?php

use App\Http\Controllers\DispatchController;
use App\Http\Controllers\LinemanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncidentsController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\UserController;
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



Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/profile', function() {
    return view('profile');
})->middleware('auth');


Route::resource('/dispatch', DispatchController::class)->only(['index', 'store']);

Route::resource('/incidents', IncidentsController::class)->only(['index', 'create', 'store']);

Route::resource('/lineman', LinemanController::class)->except(['create', 'edit']);
Route::post('/lineman/{id}/reset', [LinemanController::class, 'reset'])->name('lineman.reset');

Route::resource('/units', UnitsController::class)->except(['show', 'edit', 'update']);
Route::get('/units-search', [UnitsController::class, 'search'])->name('units.search');

Route::resource('/user', UserController::class)->except(['show', 'edit', 'update']);
