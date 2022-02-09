<?php

use App\Http\Controllers\ChangePasswordController;
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

//lineman crud
Route::get('/edit/lineman/', [LinemanController::class, 'edit']);
Route::resource('/lineman', LinemanController::class)->except(['edit']);

//lineman search
Route::get('/search/lineman/', [SearchController::class, 'search']);

//unit page
Route::get('/units', [UnitsController::class, 'index']);
Route::post('/units', [UnitsController::class, 'store']);

//admin change password
Route::middleware('auth')->group(function () {
    Route::get('/password', [ChangePasswordController::class, 'index']);
    Route::post('/password', [ChangePasswordController::class, 'ChangePass']);
});
