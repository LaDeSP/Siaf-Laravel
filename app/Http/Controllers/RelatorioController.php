<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Despesa;
use App\Models\Investimento;
use App\Models\Propriedade;
use App\Models\Talhao;
use App\Models\Platio;
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
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        // dd($request);
        // if(!(empty($request['interno']))){
            // return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=> $this->$topo, "conteudo"=>$this->$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$this->$lastLine, 'totalG'=> $this->$totalG]);
            // return $this->dat;
     //        // return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$request['todo']['topo'], "conteudo"=>$request['todo']['conteudo']]);
        // }else{
            return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "propriedades" =>$propriedades]);
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
        if ($request['tipo'] == "talhão") {
            return $this->talhoes($request);
        }else if ($request['tipo'] == "plantios") {
            return $this->plantios($request);
        }else if ($request['tipo'] == "despesa") {
            return $this->despesas($request);
        } else if($request['tipo'] == "vendas"){
             return $this->vendas($request); /* deve-se ser revisado validar campo tipo em destino; refere-se a uma venda com destino [?] ]*/
        }else if ($request['tipo'] == "investimentos") {
            $this->data=$request;
            return $this->investimentos($request);
        }
        return 405;
    }

    public function vendas(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Produto','Quantidade', 'Valor','Total','Data','Nota','Destino'];
        $lastLine= ['Produto','Total','Quantidade'];
        $data = Venda::join('destino', 'venda.destino_id','=','destino.id')
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
        ->groupBy('produto.id')->orderBy('Total', 'desc')
        ->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades]);
        // return redirect()->action("RelatorioController@index",["tipo"=>$request["tipo"], "date-inicio"=>$request['date-inicio'], "date-final"=>$request['date-final'], "interno"=>true]);

        //    $v = Venda::with(['estoque_id', 'quantidade'])
        //                 ->whereBetween('data', [$request['date-inicio'], $request['date-fim']])
        //                 ->select(DB::raw('*'));
        // $todo = array("topo"=>["Estoque","Quantidade"],"conteudo"=>$v);
        // return redirect()->action("RelatorioController@index",["todo" => $todo]);
    }
    function investimentos(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Investimento','Descrição','Data', 'Quntidade','Valor Unitário'];
        $lastLine= ['Total','Quantidade'];
        $data = Investimento::select('investimento.nome as Investimento','investimento.descricao as Descrição','investimento.data as Data', 'investimento.quantidade as Quntidade','investimento.valor_unit as Valor Unitário', (DB::raw('sum(valor_unit*quantidade) as Total')))->whereBetween('investimento.data', [$request['date-inicio'], $request['date-final']])->where('propriedade_id', '=',$propriedade->id)->groupBy('id')->get();
        $totalG= Investimento::select((DB::raw(' SUM(valor_unit*quantidade) as Total, SUM(quantidade) as Quantidade')))->whereBetween('investimento.data', [$request['date-inicio'], $request['date-final']])->where('propriedade_id', '=',$propriedade->id)->orderBy('Total', 'desc')->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades]);
    }
    function despesas(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Despesa', 'Quantidade', 'Data','Valor Unitário','Total',  'Descrição'];
        $lastLine= ['Total','Quantidade'];
        $data = Despesa::select('despesa.nome as Despesa', 'despesa.quantidade as Quantidade','despesa.valor_unit as Valor Unitário', 'despesa.data as Data', 'despesa.descricao as Descrição', (DB::raw('sum(valor_unit*quantidade) as Total')))->whereBetween('despesa.data', [$request['date-inicio'], $request['date-final']])->where('propriedade_id', '=',$propriedade->id)->groupBy('id')->get();
        $totalG= Despesa::select((DB::raw(' SUM(valor_unit*quantidade) as Total, SUM(quantidade) as Quantidade')))->whereBetween('despesa.data', [$request['date-inicio'], $request['date-final']])->where('propriedade_id', '=',$propriedade->id)->orderBy('Total', 'desc')->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades]);
    }
    function talhoes(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $topo = ['Propriedade','Talhão', 'Área'];
        $lastLine= ['Propriedade', 'Área'];
        $data = Talhao::join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
        ->select('propriedade.nome as Propriedade', 'talhao.nome as Talhão', 'talhao.area as Área')
        ->where('talhao.propriedade_id', '=',$request['propriedade_id'])
        ->groupBy('talhao.id')
        ->get();
        $totalG= Talhao::join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
        ->select(DB::raw('SUM(talhao.area) as Área, propriedade.nome as Propriedade'))
        ->where('talhao.propriedade_id', '=',$request['propriedade_id'])
        ->groupBy('talhao.propriedade_id')
        ->orderBy('Área', 'desc')
        ->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades]);
    }
    function plantios(Resquest $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Produto','Talhão', 'Quantidade', 'Platio', 'Semeadura'];
        $lastLine= [''];
        $data = Plantio::join('', '','=','')
        ->select('', (DB::raw('sum(venda.quantidade * venda.valor_unit) as Total')))
        ->whereBetween('plantio.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->groupBy('')
        ->get();
        $totalG= Venda::join('', '','=','')
        ->select((DB::raw('SUM( ) as Total, SUM() as Quantidade' )))
        ->whereBetween('plantio.data', [$request['date-inicio'], $request['date-final']])
        ->groupBy('')->orderBy('Total', 'desc')
        ->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades]);
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
