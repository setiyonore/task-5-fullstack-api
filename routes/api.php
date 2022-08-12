<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthPassportController;
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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::post('register',[AuthPassportController::class,'register']);
Route::post('login',[AuthPassportController::class,'login']);

Route::middleware('auth:api')->group(function(){
    Route::post('logout',[AuthPassportController::class,'logout']);
    Route::group(['prefix'=>'v1'],function(){
        Route::resource('post',PostController::class);
        Route::resource('category',CategoryController::class);
    });
});
