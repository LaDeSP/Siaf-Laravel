<?php

Route::name('painel.')->prefix('painel')->middleware('auth')->group(function() {
    Route::get('/', 'HomeController@index')->name('dashboard');
    Route::resource('/venda', "VendasController", ['as' => 'venda']);
    Route::resource('/estoque', "EstoqueController", ['as' => 'estoque']);
    Route::resource('/plantio', "PlantioController", ['as' => 'plantio']);
    Route::resource('/manejo', "ManejoController", ['as' => 'manejo']);
    Route::resource('/propriedade', "PropriedadeController", ['as' => 'propriedade']);
    Route::resource('/produto', "ProdutoController", ['as' => 'produto']);
    Route::resource('/talhao', "TalhaoController", ['as' => 'talhao']);
    Route::resource('/investimento',"InvestimentoController", ['as' => 'investimento']);
    Route::resource('/despesa', "DespesaController", ['as' => 'depesa']);
    Route::resource('/relatorio', "RelatorioController", ['as' => 'relatorio']);
    Route::get('/manual', "ManualController@index")->name('manual');
});

/*
Route::group(['middleware'=>['web', 'auth']], function()
{
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/quantidade/{estoque}', 'VendasController@quantidadeProduto');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/usuario', "UsersController@index");
    Route::post('/usuario', "UsersController@update");
    Route::get('/manejo/create/{plantio}', "ManejoController@create");
    Route::get('/manejo/estoque/{plantio}', "ManejoController@createEstoque");
    Route::post('/manejo/estoque/{plantio}', "ManejoController@storeEstoque");
    Route::get('/perda/{id}', "PerdaController@index");
    Route::post('/perda', "PerdaController@create");
});
*/

Route::get('/teste', function() {
    return view('teste');
});

Route::get('/', function() {
    return redirect(route('painel.dashboard'));
});

Route::get('home', function() {
    return redirect(route('painel.dashboard'));
});


Route::middleware('auth')->get('logout', function() {
    Auth::logout();
    return redirect(route('login'))->withInfo('You have successfully logged out!');
})->name('logout');

Auth::routes(['verify' => true]);

Route::name('js.')->group(function() {
    Route::get('dynamic.js', 'JsController@dynamic')->name('dynamic');
});

// Get authenticated user
Route::get('users/auth', function() {
    return response()->json(['user' => Auth::check() ? Auth::user() : false]);
});
