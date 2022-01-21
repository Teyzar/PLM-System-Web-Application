<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\MainController;

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
    return view('home');
});

// Route::post('/login', function () {
//     return view('auth.login');
// })->name('loginpage');


// Route::get('/plms', function () {
//     return view('authenticated.home');
// });


Auth::routes();

// Route::post('/plms', [MainController::class, 'postLogin'])->name('postLogin');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [App\Http\Controllers\MainController::class, 'main'])->name('dashboard');

