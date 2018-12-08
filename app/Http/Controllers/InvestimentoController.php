<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investimento;

class InvestimentoController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($action=null,$id=null)
    {
        $propriedades = null;
        $dados=array();
        $prop = new PropriedadeController();
        $propriedades= $prop->show($this->usuario['cpf']);
        if (empty($id)) {
            foreach ($propriedades as $propriedade) {
                $investimentoOne = Investimento::ler('propriedade_id', $propriedade->id);
                array_push($dados, $investimentoOne);
            }
        }
        return view('investimento',["propriedades" => $propriedades,"dados" => $dados, "User"=>$this->getFirstName($this->usuario['name']),"Tela" =>"Investimento"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request != null) {
            $investimento = Investimento::insere($request->all());
            if (!(empty($investimento))) {
                return redirect()->action('InvestimentoController@index');
            }
        }else{
            return 405;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Investimento  $investimento
     * @return \Illuminate\Http\Response
     */
    public function show($id= null,$variable=null)
    {
        return Investimento::ler($id, $variable);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Investimento  $investimento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {    $investimento = Investimento::alterar($request, $id);
        if($investimento == 200){
            return  redirect()->action('InvestimentoController@index');
        }
        return 405;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Investimento  $investimento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $investimento = Investimento::excluir($id);
        if($investimento == 200){
            return  redirect()->action('InvestimentoController@index');
        }
        return 405;
    }
}
