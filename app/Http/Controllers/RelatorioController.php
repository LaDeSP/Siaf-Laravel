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
    	if($request['topo']){
            return $request;
            // return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$request['todo']['topo'], "conteudo"=>$request['todo']['conteudo']]);
        }else{
            return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório"]);
        }
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
        	$topo = ['Despesa', 'Quantidade', 'Valor Unitário', 'Data', 'Descrição'];
            $d = DB::table('despesa')->whereBetween('data', [$request['date-inicio'], $request['date-final']])->get(['despesa.nome', 'despesa.quantidade', 'despesa.valor_unit', 'despesa.data', 'despesa.descricao']);
            return redirect()->action("RelatorioController@index", ["conteudo"=> $d]);
        // return $this->despesas($request);
        } else if($request['tipo'] == "vendas"){
             return $this->vendas($request);
        }
        return 405;
    }
    public function vendas(Request $request){
           $v = Venda::with(['estoque_id', 'quantidade'])
                        ->whereBetween('data', [$request['date-inicio'], $request['date-fim']])
                        ->select(DB::raw('*'));
        $todo = array("topo"=>["Estoque","Quantidade"],"conteudo"=>$v);
        return redirect()->action("RelatorioController@index",["todo" => $todo]);
    }
    function despesas(Request $request){
        $topo = ['Despesa', 'Quantidade', 'Valor Unitário', 'Data', 'Descrição'];
        $d = DB::table('despesa')->whereBetween('data', [$request['date-inicio'], $request['date-final']])->get(['despesa.nome', 'despesa.quantidade', 'despesa.valor_unit', 'despesa.data', 'despesa.descricao']);
        // return $d;
        // $de= array();
        // foreach ($d as $key => $value) {
        //     array_push($de, $value);
        // }
         // $todo = ["conteudo"=> $d,"topo"=>$topo];
         // return $t;
        // var_dump($t);
         // dd($todo);
         return redirect()->action("RelatorioController@index", $d);
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
