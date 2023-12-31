<?php

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/showData', [AuthController::class, 'showUserData']);
    Route::apiResource('/blog', MedsController::class);
    Route::apiResource('/order', OrderController::class);
});
Route::get('/cat/med', [CatController::class, 'catIndex']);
Route::get('/cat', [CatController::class, 'getCats']);
Route::get('/med', [CatController::class, 'getMeds']);
Route::get('/searchcats/{cat}', [CatController::class, 'searchCats']);
Route::get('/searchcats/{cat}/{med}', [CatController::class, 'searchInCat']);

Route::get('/sales', [SalesController::class, 'getSales']);
Route::get('/popular', [SalesController::class, 'mostPopular']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);