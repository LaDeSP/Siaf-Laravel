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
    	$propriedade = $this->getPropriedade($request);
    	return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatorio"]);
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
        if ($request['qual'] == "despesa") {
        	$despesa = DB::table('despesa')->whereBetween('data', [$request['date-inicio'], $request['date-fim']])->where('despesa.deleted_at','=',null)->get(['despesa.nome', 'despesa.quantidade', 'despesa.valor_unit', 'despesa.data', 'despesa.descricao']);
        	$topo= '<tr><th>Despesa</th><th>Quantidade</th><th>Valor Unitário</th><th>Data</th><th>Descrição</th></tr>';
        	$topoGraph= '<tr><th>Data</th><th>Valor</tr>';
        	$dado='';
        	$dadoGraph='';
        	// foreach ($despesa as  $key => $value) {
        	// 	$dado=$dado.'<tr><td>'. $value->nome .'</td><td>'. $value->quantidade .'</td><td>'.$value->valor_unit.'</td><td class="data">'.\Carbon\Carbon::parse($value->data)->format('d/m/Y').'</td><td>'.$value->descricao.'</td></tr>';
        	// 	$dadoGraph=$dadoGraph.'<tr><td class="data">'.\Carbon\Carbon::parse($value->data)->format('d/m/Y') .'</td><td>'.($value->valor_unit * $value->quantidade).'</td></tr>';
        	// }
        	$todo= array('dado' => $dado, 'topo'=> $topo,'dadoGraph' => $dadoGraph, 'topoGraph'=> $topoGraph );
        	return $todo;
        }
        else if($request['qual'] == "vendas"){
            return $this->vendas($request);
        }
        return 405;
    }

    public function vendas(Request $request){
           $v = Venda::with(['estoque_id', 'quantidade'])
                        ->whereBetween('data', [$request['date-inicio'], $request['date-fim']])
                        ->select(DB::raw('*'));
         /*   $despesa = DB::table('despesa')->whereBetween()->get(['despesa.nome', 'despesa.quantidade', 'despesa.valor_unit', 'despesa.data', 'despesa.descricao']);*/
            $topoGraph= '<tr><th>Estoque</th><th>Quantidade</tr>';
            $dadoGraph='';
            foreach ($v as  $key => $value) {
                $dadoGraph=$dadoGraph.'<tr><td>'.($value->estoque_id).'</td><td>'.$value->quantidade.'</td></tr>';
            }
            $todo= array('dadoGraph' => $dadoGraph, 'topoGraph'=> $topoGraph );
            return $todo;
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
