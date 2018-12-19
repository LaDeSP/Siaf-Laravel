<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cidade;
use App\Models\Propriedade;
use App\Models\Venda;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vendas = $this->vendas($request);
        $propiedades=Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $dadosPropriedade = DB::table('propriedade')
        ->join('cidade', 'cidade.id', '=', 'cidade_id')
        ->join('estado', 'estado.id','=', 'cidade.estado_id')
        ->select('cidade.nome AS cidade', 'estado.nome AS estado')
        ->where('propriedade.users_id','=', $this->usuario['cpf'])->first();
        $propiedade=array_first($propiedades);
        $cidade=Cidade::cordenadas($propiedade['cidade_id']);

        return view('welcome',["User"=>$this->getFirstName($this->usuario['name']),"Propriedade"=>$propiedade,'dadosP'=>$dadosPropriedade,"Vendas"=>$vendas,"Tela"=>"Início",'Longitude'=> $cidade['longitude'],"Latitude" => $cidade['latitude']]);
    }

    public function vendas($request)
    {
        $propriedade = $this->getPropriedade($request);
        $dataAtual = new \DateTime();
        $datafim = $dataAtual->format('Y-m-d H:i:s');
        $data=date('Y-m-d',strtotime("-15 day", strtotime($datafim)));
        $totalG= Venda::join('destino', 'venda.destino_id','=','destino.id')
        ->join('estoque', 'venda.estoque_id','=','estoque.id')
        ->leftJoin('produto', 'estoque.produto_id','=','produto.id')
        ->select((DB::raw('produto.nome as produto, SUM(venda.quantidade * venda.valor_unit) as total, SUM(venda.quantidade) as total_unidade' )))
        ->whereBetween('venda.data', [$data, $datafim])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->where('destino.tipo', '=',1)
        ->groupBy('produto.id')->orderBy('total', 'desc')
        ->limit(3)
        ->get();
        return $totalG;
    }
}
