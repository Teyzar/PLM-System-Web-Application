<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;


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

Route::get('/main', [LoginController::class, 'index']);
Route::post('/main/checklogin', [LoginController::class, 'checklogin']);


Route::get('/', function () {
    return view('pages.default');
});

Route::get('/login', function () {
    return view('pages.login');
});