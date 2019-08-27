<?php

Route::name('painel.')->prefix('painel')->middleware('auth')->group(function() {
    Route::get('/', 'HomeController@index')->name('dashboard');
    Route::resource('/venda', "VendasController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    Route::resource('/estoque', "EstoqueController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    Route::get('/estoque/p/plantio', 'EstoqueController@estoquePlataveisIndex')->name('estoquePlantaveis');
    Route::get('/estoque/p/propriedade', 'EstoqueController@estoquePropriedadeIndex')->name('estoquePropriedade');
    Route::resource('/plantio', "PlantioController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    Route::resource('/manejo', "ManejoController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    Route::resource('/propriedade', "PropriedadeController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    Route::resource('/produto', "ProdutoController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    Route::resource('/talhao', "TalhaoController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    Route::resource('/investimento',"InvestimentoController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    Route::resource('/despesa', "DespesaController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    Route::resource('/relatorio', "RelatorioController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
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
