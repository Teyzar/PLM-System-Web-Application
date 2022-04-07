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
Route::get('/about', function() {
    return view('about');
});



Route::resource('/dispatch', DispatchController::class)->only(['index']);
Route::get('/incidents/{id}/dispatch', [DispatchController::class, '_dispatch'])->name('incidents.dispatch');
Route::post('/incidents/{id}/dispatch', [DispatchController::class, 'store'])->name('dispatch.store');


Route::resource('/incidents', IncidentsController::class)->except('add');
Route::post('/incidents/{id}/add', [IncidentsController::class, 'add'])->name('incidents.add');

Route::resource('/lineman', LinemanController::class)->except(['create', 'edit']);
Route::post('/lineman/{id}/reset', [LinemanController::class, 'reset'])->name('lineman.reset');

Route::resource('/units', UnitsController::class)->except(['show', 'edit', 'update']);
Route::get('/units/{id}/refresh', [UnitsController::class, 'refresh'])->name('unit.refresh');

Route::resource('/user', UserController::class)->except(['show', 'edit', 'update']);
