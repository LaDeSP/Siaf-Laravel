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

Route::group(['middleware'=>['web', 'auth']], function()
{
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/propriedade', "PropriedadeController@index");
    Route::get('/usuario', "UsersController@index");
    Route::get('/manejo', "ManejoController@index");
    Route::get('/despesa', "DespesaController@index");
    Route::get('/manual', "ManualController@index");
    Route::get('/investimento',"InvestimentoController@index");
    Route::get('/plantio', "PlantioController@index");
    Route::get('/relatorio', "RelatorioController@index");
    Route::get('/venda', "VendasController@index");
    Route::get('/estoque', "EstoqueController@create");
});
