<?php

Route::redirect('/', '/login');
Route::get('/cidades/{id}', 'CidadeController@show');

Auth::routes();

// route to show the login form
Route::group(['prefix'=> 'api', 'middleware'=>['web', 'auth']], function (){
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
    Route::resource('/manejo', "ManejoController");
    Route::get('/manejo/create/{plantio}', "ManejoController@create");
    Route::resource('/despesa', "DespesaController");
    Route::get('/manual', "ManualController@index");
    Route::resource('/investimento',"InvestimentoController");
    Route::resource('/plantio', "PlantioController");
    Route::get('/relatorio', "RelatorioController@index");
    Route::get('/venda', "VendasController@index");
    //Route::get('/estoque', "EstoqueController@create");
});
