<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'document'], function() {
    Route::post('/','DocumentController@create');
    Route::put('/{id}','DocumentController@update');
    Route::delete('/{id}','DocumentController@delete');
    Route::get('/{id}','DocumentController@show');
    Route::get('/list','DocumentController@list');
});