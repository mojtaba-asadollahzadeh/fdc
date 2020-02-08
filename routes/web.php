<?php

Route::get('/', function () {
	 // Fetch all customers from database
    $doc = App\Doc::first();
    // Send data to the view using loadView function of PDF facade
    $pdf = PDF::loadView('doc', compact('doc'));
    // Finally, you can download the file using download function
    return $pdf->download('doc');
});


Route::group(['prefix' => 'docs'], function() {
    Route::get('/new', 'DocController@new');
    Route::get('/edit/{id}', 'DocController@show');
    Route::post('/new', 'DocController@save');
    Route::get('/{id}', 'DocController@show');
});