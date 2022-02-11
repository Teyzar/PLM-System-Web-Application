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

// Public Routes

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/heatmap-data', [UnitsController::class, 'heatmap']);


// Protected Routes

Route::middleware('auth')->group(function () {
    Route::resource('/lineman', LinemanController::class)->except(['create', 'edit']);
    Route::post('/lineman/{id}/reset', [LinemanController::class, 'reset']);
    Route::get('/lineman-search', [LinemanController::class, 'search']);

    Route::resource('/password', ChangePasswordController::class)->only(['index', 'store']);

    Route::resource('/units', UnitsController::class)->only(['index', 'store']);
});
