<?php

Route::redirect('/', '/login');

Auth::routes();

// route to show the login form
Route::group(['prefix'=> 'api'], function (){
    Route::get('/{name}/{id?}/{variable?}', 'CrudController@show');
    Route::put('/{name}/{id?}', 'CrudController@update');
    Route::delete('/{name}/{id?}', 'CrudController@destroy');
    Route::post('/{name}', 'CrudController@store');
});

Route::group(['middleware'=>['web']], function()
{
    Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
    Route::get('/propriedade', "PropriedadeController@index")->middleware('auth');
});
