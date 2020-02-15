<?php

Route::get('/', function () {
	 
});


Route::group(['prefix' => 'docs'], function() {
    Route::get('/new', 'DocController@new');
    Route::get('/edit/{id}', 'DocController@edit');
    Route::get('/', 'DocController@index');
    Route::get('/{id}', 'DocController@show');
});