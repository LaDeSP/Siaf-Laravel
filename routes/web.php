<?php

Route::name('painel.')->prefix('painel')->middleware('auth')->group(function() {
    
    /*Rotas referente a home*/
    Route::get('/', 'HomeController@index')->name('dashboard');

    /*Rotas referente a venda*/
    Route::resource('/venda', "VendasController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    
    /*Rotas referente a estoque*/
    Route::resource('/estoque', "EstoqueController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    Route::get('/estoque/produto/plantio', 'EstoqueController@estoquePlataveisIndex')->name('estoquePlantaveis');
    Route::get('/estoque/produto/processado', 'EstoqueController@estoqueProcessadoIndex')->name('estoqueProcessado');
    Route::get('/plantio/colheita/{manejo}/estoque', "ManejoController@createEstoqueColheitaManejo")->name('createEstoqueColheitaManejo');
    Route::post('/plantio/colheita/{manejo}/estoque', "ManejoController@storeEstoqueColheitaManejo")->name('storeEstoqueColheitaManejo');
    
    /*Rotas referente a plantio*/
    Route::resource('/plantio', "PlantioController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
        
    /*Rotas referente a perda*/
    Route::get('plantio/{plantio}/create/perda', "PerdaController@createPerdaPlantio")->name('createPerdaPlantio');
    Route::post('/perda/plantio/{plantio}', "PerdaController@storePerdaPlantio")->name('storePerdaPlantio');
    Route::get('estoque/{estoque}/create/perda', "PerdaController@createPerdaEstoque")->name('createPerdaEstoque');
    Route::post('/perda/estoque/{estoque}', "PerdaController@storePerdaEstoque")->name('storePerdaEstoque');

    /*Rotas referente a manejo*/
    Route::resource('/manejo', "ManejoController", ['names' => [
        'edit', 'update', 'destroy']])->except('create', 'store');
    Route::get('plantio/{plantio}/create/manejo', "ManejoController@create")->name('manejoCreate');
    Route::post('plantio/{plantio}/create/manejo', "ManejoController@store")->name('manejoSave');
    Route::get('/plantio/{plantio}/manejos', 'ManejoController@showManejosPlantios')->name('manejosPlantios');
    

    /*Rotas referente a propriedade*/
    Route::resource('/propriedade', "PropriedadeController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);

    /*Rotas referente a produto*/
    Route::resource('/produto', "ProdutoController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    
    /*Rotas referente a talhao*/
    Route::resource('/talhao', "TalhaoController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);

    /*Rotas referente a investimento*/
    Route::resource('/investimento',"InvestimentoController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    
    /*Rotas referente a despesa*/
    Route::resource('/despesa', "DespesaController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);

    /*Rotas referente a relatorio*/
    Route::resource('/relatorio', "RelatorioController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    
    /*Rotas referente a calendario*/
    Route::get('/calendario', 'CalendarioController@index')->name('calendario');
    
    /*Rotas referente a manual*/
    Route::get('/manual', "ManualController@index")->name('manual');

    Route::get('/estoque/{id}/quantidade', 'VendasController@quantidadeProdutoEstoque');
});

/*
Route::group(['middleware'=>['web', 'auth']], function()
{
    
    Route::get('/usuario', "UsersController@index");
    Route::post('/usuario', "UsersController@update");
    Route::get('/perda/{id}', "PerdaController@index");
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
