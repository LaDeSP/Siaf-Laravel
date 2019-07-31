<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cidade;
use App\Models\Propriedade;
use App\Models\Venda;
use App\Models\Perda;
use App\Models\Estoque;
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
        $estoques = $this->estoques($request);
        $propiedades=Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $dadosPropriedade = DB::table('propriedade')
        ->join('cidade', 'cidade.id', '=', 'cidade_id')
        ->join('estado', 'estado.id','=', 'cidade.estado_id')
        ->select('cidade.nome AS cidade', 'estado.nome AS estado')
        ->where('propriedade.users_id','=', $this->usuario['cpf'])->first();
        $propiedade=array_first($propiedades);
        $cidade=Cidade::cordenadas($propiedade['cidade_id']);

        return view('welcome',["User"=>$this->getFirstName($this->usuario['name']),"Propriedade"=>$propiedade,'dadosP'=>$dadosPropriedade,"Vendas"=>$vendas, 'estoques'=>$estoques,"Tela"=>"Início",'Longitude'=> $cidade['longitude'],"Latitude" => $cidade['latitude']]);
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
        ->groupBy('produto.id')->orderBy('total_unidade', 'desc')
        ->limit(3)
        ->get();
        return $totalG;
    }

    public function estoques($request)
    {
        $propriedade = $this->getPropriedade($request);
        $dataAtual = new \DateTime();
        $datafim = $dataAtual->format('Y-m-d H:i:s');
        $data=date('Y-m-d',strtotime("-15 day", strtotime($datafim)));
        $totalG=Estoque::leftJoin('manejoplantio', 'estoque.manejoplantio_id','=','manejoplantio.id')
        ->leftJoin('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->leftJoin('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('produto', 'estoque.produto_id','=','produto.id')
        ->join('propriedade', 'estoque.propriedade_id','=','propriedade.id')
        ->select('estoque.produto_id','propriedade.nome as propriedade','produto.nome as produto',DB::raw('SUM(estoque.quantidade) as total'),DB::raw('SUM(estoque.quantidade) as total_atual'))
        ->whereBetween('estoque.data', [$data, $datafim])
        ->where('estoque.propriedade_id', '=', $propriedade->id)
        ->groupBy('produto.id')->orderBy('total_atual', 'desc')
        ->limit(3)
        ->get();

        foreach ($totalG as $key => $value) {
            $pv = (Venda::join('estoque','venda.estoque_id','=','estoque.id')
            ->where('estoque.produto_id','=',$value->produto_id)
            ->where('estoque.propriedade_id','=',$propriedade->id)
            ->whereBetween('estoque.data', [$data, $datafim])
            ->sum('venda.quantidade'))
            +
            (Perda::join('estoque','perda.estoque_id','=','estoque.id')
            ->where('estoque.produto_id','=',$value->produto_id)
            ->where('estoque.propriedade_id','=',$propriedade->id)
            ->whereBetween('estoque.data', [$data, $datafim])
            ->sum('perda.quantidade'));
            $value->total_atual= $value->total_atual - $pv;
        }
        return $totalG;
    }
}
