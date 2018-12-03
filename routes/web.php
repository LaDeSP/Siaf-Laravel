<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// route to show the login form
Route::group(['prefix'=> 'api'], function (){
    Route::get('/{name}/{id?}/{variable?}', 'CrudController@show');
    Route::put('/{name}/{id?}', 'CrudController@update');
    Route::delete('/{name}/{id?}', 'CrudController@destroy');
    Route::post('/{name}', 'CrudController@store');
});

Route::get('login', 'home@login');
Route::post('autentica', 'home@autentica');
Route::get('novo', 'home@novo');
Route::post('grava', 'home@salva');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/propriedade', "PropriedadeController@index");
Route::get('/investimento', "InvestimentoController@create");