<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Estoque;
use App\Models\Manejo;
use App\Models\ManejoPlantio;
use App\Models\Plantio;
use App\Models\Produto;
use App\Models\Propriedade;
use App\Models\Talhao;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropriedadeController extends Controller
{
    private $totalpage=3;
    /**
     * Display a listing of the resource.
     *
     * @return Propriedade[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $prop = $this->getPropriedade($request);
        $talhao = Talhao::where('propriedade_id','=',$prop['id'])->paginate(3);
        $produto = Produto::all()->where('propriedade_id','=',$prop['id']);
        foreach ($produto as $p){
            $p['unidade_id'] = DB::table('unidade')->where('id', $p['unidade_id'])->where('unidade.deleted_at','=',null)->value('nome');
        }
        if($request['mensagem']){
            return view('propriedades', ["propriedade"=>$prop,"talhao"=>$talhao, "unidades"=>Unidade::get(["id","nome"]),"produto"=>$produto, "User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Propriedade", 'mensagem'=>$request['mensagem'],'status'=>$request['status']]);
        }else{
            return view('propriedades', ["propriedade"=>$prop,"talhao"=>$talhao, "unidades"=>Unidade::get(["id","nome"]),"produto"=>$produto, "User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Propriedade"]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Propriedade::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prop = Propriedade::find($id);
        $tcidade = Cidade::find($prop->cidade_id);
        $testado = Estado::find($tcidade["estado_id"]);
        return view('propriedadesForm',["propriedade"=>$prop, "mestado"=>$testado, "mcidade"=>$tcidade, 'estados'=>Estado::all(), 'Method'=>'put','Url'=>'/propriedade'.'/'.$id]);
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
        if ($request != null and $id != null) {
            $ret = Propriedade::atualizar($request, $id);
            if( $ret == 200){
                $status='success';
                $mensagem='Propriedade atualizada com sucesso!';
            }else{
                $status='danger';
                $mensagem='Ocorreu um erro ao atualizar sua propriedade!';
            }
            $this->setPropriedade($request, $id);
            return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status]);
        }else{
            return redirect()->action('PropriedadeController@index');
        }
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

    public static function findUsageT($param){
        try{
            if(Plantio::where('talhao_id','=',$param['id'])->firstOrFail())
                return true;
        }catch(\Exception $e){
            return false;
        }
    }

    public static function findUsageP($param){
        try{
            if( Estoque::where('produto_id','=',$param['id'])->first() || Plantio::where('produto_id','=',$param['id'])->first())
                return true;
            return false;
        }catch(\Exception $e){
            return false;
        }
    }
}
