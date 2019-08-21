<?php

use App\Models\User;

/*Route::redirect('/', '/login');
Route::get('/cidades/{id}', 'CidadeController@show');

Auth::routes();

Route::group(['middleware'=>['web', 'auth']], function()
{
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/quantidade/{estoque}', 'VendasController@quantidadeProduto');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::resource('/propriedade', "PropriedadeController");
    Route::get('/usuario', "UsersController@index");
    Route::post('/usuario', "UsersController@update");
    Route::resource('/manejo', "ManejoController");
    Route::get('/manejo/create/{plantio}', "ManejoController@create");
    Route::get('/manejo/estoque/{plantio}', "ManejoController@createEstoque");
    Route::post('/manejo/estoque/{plantio}', "ManejoController@storeEstoque");
    Route::resource('/despesa', "DespesaController");
    Route::get('/manual', "ManualController@index");
    Route::resource('/investimento',"InvestimentoController");
    Route::resource('/plantio', "PlantioController");
    Route::resource('/relatorio', "RelatorioController");
    Route::resource('/venda', "VendasController");
    Route::resource('/estoque', "EstoqueController");
    Route::resource('/produto', "ProdutoController");
    Route::resource('/talhao', "TalhaoController");
    Route::get('/perda/{id}', "PerdaController@index");
    Route::post('/perda', "PerdaController@create");
});
*/

Route::get('/todos', function(){
    $all = User::all();
    return response()->json($all);
});

Route::get('/teste', function(){
    return view('teste');
});

Route::get('/', function() {
    return redirect(route('painel.dashboard'));
});

Route::get('home', function() {
    return redirect(route('painel.dashboard'));
});

Route::name('painel.')->prefix('painel')->middleware('auth')->group(function() {
    Route::get('/', 'DashboardController')->name('dashboard');
    Route::resource('users', 'UserController', [
        'names' => [
            'index' => 'users'
        ]
    ]);
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
