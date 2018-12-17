<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;
use App\Models\Despesa;
use App\Models\Investimento;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request);
    	// if($request['topo']){
     //        return $request;
     //        // return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$request['todo']['topo'], "conteudo"=>$request['todo']['conteudo']]);
     //    }else{
            return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório"]);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['tipo'] == "despesa") {
            return $this->despesas($request);
        } else if($request['tipo'] == "vendas"){
             return $this->vendas($request);
        }
        return 405;
    }
    public function vendas(Request $request){
        $propriedade = $this->getPropriedade($request);
        $topo = ['Produto','Quantidade', 'Valor','Total','Data','Nota','Destino'];
        $lastLine= ['Produto','Total','Quantidade'];
        $vendas = Venda::join('destino', 'venda.destino_id','=','destino.id')
        ->join('estoque', 'venda.estoque_id','=','estoque.id')
        ->leftJoin('produto', 'estoque.produto_id','=','produto.id')
        ->select('produto.nome as Produto','venda.quantidade as Quantidade', 'venda.valor_unit as Valor', 'venda.data as Data', 'venda.nota as Nota','destino.nome as Destino', (DB::raw('sum(venda.quantidade * venda.valor_unit) as Total')))
        ->whereBetween('venda.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->where('destino.tipo', '=',1)
        ->groupBy('venda.id')
        ->get();
        $totalG= Venda::join('destino', 'venda.destino_id','=','destino.id')
        ->join('estoque', 'venda.estoque_id','=','estoque.id')
        ->leftJoin('produto', 'estoque.produto_id','=','produto.id')
        ->select((DB::raw('produto.nome as Produto, SUM(venda.quantidade * venda.valor_unit) as Total, SUM(venda.quantidade) as Quantidade' )))
        ->whereBetween('venda.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->where('destino.tipo', '=',1)
        ->groupBy('produto.id')
        ->get();
         return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$vendas, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG]);

        //    $v = Venda::with(['estoque_id', 'quantidade'])
        //                 ->whereBetween('data', [$request['date-inicio'], $request['date-fim']])
        //                 ->select(DB::raw('*'));
        // $todo = array("topo"=>["Estoque","Quantidade"],"conteudo"=>$v);
        // return redirect()->action("RelatorioController@index",["todo" => $todo]);
    }
    function despesas(Request $request){
        $propriedade = $this->getPropriedade($request);
        $topo = ['Despesa', 'Quantidade', 'Data','Valor Unitário','Total',  'Descrição'];
        $lastLine= ['Total','Quantidade'];
        $despesas = Despesa::select('despesa.nome as Despesa', 'despesa.quantidade as Quantidade','despesa.valor_unit as Valor Unitário', 'despesa.data as Data', 'despesa.descricao as Descrição', (DB::raw('sum(valor_unit*quantidade) as Total')))->whereBetween('data', [$request['date-inicio'], $request['date-final']])->where('propriedade_id', '=',$propriedade->id)->groupBy('id')->get();
        $totalG= Despesa::select((DB::raw(' SUM(valor_unit*quantidade) as Total, SUM(quantidade) as Quantidade')))->whereBetween('data', [$request['date-inicio'], $request['date-final']])->where('propriedade_id', '=',$propriedade->id)->get();
         return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$despesas, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $qual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
