<?php

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'docs'], function() {
    Route::get('/new', 'DocController@new');
    Route::post('/new', 'DocController@save');
    Route::get('/{id}', 'DocController@show');
});