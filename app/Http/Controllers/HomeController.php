<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Estoque;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller{
    protected $userService;
    protected $modelVenda;
    protected $modelEstoque;

    public function __construct(UserService $userService, Venda $venda, Estoque $estoque){
        $this->middleware('auth');
        $this->userService = $userService;
        $this->modelVenda = $venda;
        $this->modelEstoque = $estoque;
    }

    public function index(){
        $propriedade = $this->userService->propriedadesUser();
        $topCincoProdutosMaisVendidos = $this->modelVenda->topCincoProdutosMaisVendidos($propriedade);
        $vendasUltimoQuinzeDias = $this->modelVenda->vendasUltimosQuinzeDias($propriedade);
        $estoquesUltimoQuinzeDias = $this->modelEstoque->estoquesUltimosQuinzeDias($propriedade);
        return view('painel.dashboard.index', ["propriedade"=>$propriedade, "vendas"=>$vendasUltimoQuinzeDias, "estoques"=>$estoquesUltimoQuinzeDias, "produtos"=>$topCincoProdutosMaisVendidos]);
    }
}
