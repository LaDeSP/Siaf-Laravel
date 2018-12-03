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
Route::get('login', 'home@login');
Route::post('autentica', 'home@autentica');
Route::get('novo', 'home@novo');
Route::post('grava', 'home@salva');


Route::get('/', function () {
    return view('welcome');
});
