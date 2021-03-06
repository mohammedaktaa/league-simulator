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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('leagues', 'API\LeaguesController@index');
Route::get('leagues/{league}', 'API\LeaguesController@show');
Route::post('leagues/{league}/init', 'API\LeaguesController@init');
Route::post('leagues/{league}/play_week', 'API\LeaguesController@playWeek');
Route::post('leagues/{league}/play_all', 'API\LeaguesController@playAll');
