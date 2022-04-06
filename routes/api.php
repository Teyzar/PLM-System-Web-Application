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


Route::resource('/lineman', LinemanApiController::class, ['as' => 'api'])->only(['index', 'update']);
Route::get('/lineman/{id}/incidents', [LinemanApiController::class, 'incidents'])->name('api.lineman.incidents');
Route::post('/lineman/login', [LinemanApiController::class, 'login'])->name('api.lineman.login');
Route::post('/lineman/logout', [LinemanApiController::class, 'logout'])->name('api.lineman.logout');

Route::resource('/units', UnitsApiController::class, ['as' => 'api'])->only(['update']);
Route::get('/units/heatmap', [UnitsApiController::class, 'heatmap'])->name('api.units.heatmap');

Route::resource('/user', UserApiController::class, ['as' => 'api'])->only(['index']);
Route::post('/user/login', [UserApiController::class, 'login'])->name('api.user.login');
Route::post('/user/logout', [UserApiController::class, 'logout'])->name('api.user.logout');
