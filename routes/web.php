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

Route::get('/lineman/edit/', [LinemanController::class, 'edit'])->name('lineman-edit');
Route::resource('/lineman', LinemanController::class)->only(['index', 'store', 'show', 'destroy', 'update']);


Route::get('/search/', [SearchController::class, 'search']);

Route::get('/units', [UnitsController::class, 'index'])->name('units');
Route::post('/units', [UnitsController::class, 'store'])->name('add_unit');



Route::middleware('auth')->group(function() {
    Route::get('/password', [ChangePasswordController::class, 'index'])->name('c-password');
    Route::post('/', [ChangePasswordController::class, 'ChangePass'])->name('save-password');
});
