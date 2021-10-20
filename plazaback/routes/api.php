<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login',[\App\Http\Controllers\UserController::class,'login']);
Route::post('/register',[\App\Http\Controllers\UserController::class,'register']);
Route::get('/historial/{ci}',[\App\Http\Controllers\HistorialController::class,'show']);
Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::post('/logout',[\App\Http\Controllers\UserController::class,'logout']);
    Route::post('/me',[\App\Http\Controllers\UserController::class,'me']);
    Route::put('/pass/{user}',[\App\Http\Controllers\UserController::class,'pass']);
    Route::put('/updatepermisos/{user}',[\App\Http\Controllers\UserController::class,'updatepermisos']);
    Route::post('/fhistorial',[\App\Http\Controllers\HistorialController::class,'fhistorial']);
    Route::post('/imprimir',[\App\Http\Controllers\HistorialController::class,'imprimir']);

    Route::resource('/user',\App\Http\Controllers\UserController::class);
    Route::resource('/cliente',\App\Http\Controllers\ClienteController::class);
    Route::resource('/recarga',\App\Http\Controllers\RecargaController::class);
    Route::resource('/historial',\App\Http\Controllers\HistorialController::class);

    Route::resource('/permiso',\App\Http\Controllers\PermisoController::class);
});



