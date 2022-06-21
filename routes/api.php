<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Dashboard\TagController;
use App\Http\Controllers\Api\Dashboard\CategoryController;
use App\Http\Controllers\Api\Dashboard\FilmController;


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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('profile', [AuthController::class, 'userProfile']);

    Route::prefix('dashboard')->group(function() {
        
        #TAG
        Route::prefix('tag')->group(function() {
            Route::get('/', [TagController::class, 'show']);
            Route::post('/', [TagController::class, 'create']);
            Route::put('/', [TagController::class, 'update']);
            Route::delete('/', [TagController::class, 'delete']);
        });

        #CATEGORY
        Route::prefix('category')->group(function() {
            Route::get('/', [CategoryController::class, 'show']);
            Route::post('/', [CategoryController::class, 'create']);
            Route::put('/', [CategoryController::class, 'update']);
            Route::delete('/', [CategoryController::class, 'delete']);
        });

        #FILM
        Route::prefix('film')->group(function() {
            Route::get('/', [FilmController::class, 'show']);
            Route::post('/', [FilmController::class, 'create']);
            Route::put('/', [FilmController::class, 'update']);
            Route::delete('/', [FilmController::class, 'delete']);
        });
    });

});
