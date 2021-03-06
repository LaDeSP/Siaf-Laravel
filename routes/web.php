<?php

Route::get('/cidades/{id}', 'CidadeController@show');

Route::name('painel.')->prefix('painel')->middleware('auth')->group(function() {
    
    /*Rotas referente a home*/
    Route::get('/', 'HomeController@index')->name('dashboard');

    /*Rotas referente a venda*/
    Route::resource('/venda', "VendasController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
    
    /*Rotas referente a estoque*/
    Route::resource('/estoque', "EstoqueController", ['names' => [
        'create', 'store', 'edit', 'update', 'destroy']]);
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
    Route::get('/relatorio', 'RelatorioController@index')->name('indexRelatorio');    
    Route::get('/relatorio/gerar', 'RelatorioController@gerarRelatorio')->name('gerarRelatorio');
        
    /*Rotas referente a calendario*/
    Route::get('/calendario', 'CalendarioController@index')->name('calendario');
    
    /*Rotas referente a manual*/
    Route::get('/manual', "ManualController@index")->name('manual');

    Route::get('/estoque/{estoque}/quantidade', 'VendasController@quantidadeProdutoEstoque');

    /*Rotas referente a perfil usuario*/
    Route::get('/user/{user}', "UsersController@edit")->name('perfil');
    Route::put('/user/{user}', "UsersController@update")->name('perfil');
});

Route::get('/', function() {
    return redirect(route('painel.dashboard'));
});

Route::get('home', function() {
    return redirect(route('painel.dashboard'));
});

Route::middleware('auth')->get('logout', function() {
    Auth::logout();
    return redirect(route('login'))->withInfo('Você saiu com sucesso!');
})->name('logout');

Auth::routes(['verify' => true]);

Route::name('js.')->group(function() {
    Route::get('dynamic.js', 'JsController@dynamic')->name('dynamic');
});

// Get authenticated user
Route::get('users/auth', function() {
    return response()->json(['user' => Auth::check() ? Auth::user() : false]);
});
