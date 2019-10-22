<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/movies/{imdbId}', 'MoviesController@newMovie');
Route::get('/movies/{imdbId}', 'MoviesController@getMovieInfo');
Route::post('/tokens/{tokenId}', 'MoviesController@addRightsHolder');
Route::get('/tokens/{tokenId}', 'MoviesController@listRightsHolders');
