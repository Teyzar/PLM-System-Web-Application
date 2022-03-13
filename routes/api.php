<?php


use App\Http\Controllers\LinemanApiController;
use App\Http\Controllers\UnitsApiController;
use App\Http\Controllers\UserApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::resource('/lineman', LinemanApiController::class, ['as' => 'api'])->only(['update']);
Route::post('/lineman/login', [LinemanApiController::class, 'login'])->name('api.lineman.login');

Route::resource('/units', UnitsApiController::class, ['as' => 'api'])->only(['update']);

Route::resource('/user', UserApiController::class, ['as' => 'api'])->only(['index']);
Route::post('/user/login', [UserApiController::class, 'login'])->name('api.user.login');
Route::post('/user/logout', [UserApiController::class, 'logout'])->name('api.user.logout');
