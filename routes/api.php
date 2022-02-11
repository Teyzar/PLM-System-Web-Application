<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\UnitsController;
use Illuminate\Http\Request;
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

// Public Routes

Route::post('/auth/register', [ApiAuthController::class, 'register']);
Route::post('/auth/login', [ApiAuthController::class, 'login']);


// Protected Routes

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [ApiAuthController::class, 'logout']);

    Route::patch('/units/{phone_number}', [UnitsController::class, 'update']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
