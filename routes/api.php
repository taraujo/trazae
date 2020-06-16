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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('refresh', 'Api\AuthController@refresh');
    Route::post('me', 'Api\AuthController@me');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'usuarios'
], function ($router) {
    Route::get('/', 'Api\UsuarioController@index');
    Route::post('/', 'Api\UsuarioController@store');
    Route::get('/{id}', 'Api\UsuarioController@show');
    Route::put('/', 'Api\UsuarioController@update');
    Route::delete('/{id}', 'Api\UsuarioController@destroy');
});
