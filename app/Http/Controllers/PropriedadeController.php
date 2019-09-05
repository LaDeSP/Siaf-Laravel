<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PropriedadeService;
use App\Services\EstadoService;
use App\Services\CidadeService;
use App\Services\UserService;

class PropriedadeController extends Controller{
    protected $propriedadeService;
    protected $estadoService;
    protected $cidadeService;
    protected $userService;

    public function __construct(PropriedadeService $propriedadeService, UserService $userService, EstadoService $estadoService, CidadeService $cidadeService){
        $this->propriedadeService = $propriedadeService;
        $this->estadoService = $estadoService;
        $this->cidadeService = $cidadeService;
        $this->userService = $userService;
    }
    
    public function index(Request $request){
        dd($request);
        $prop = $this->userService->propriedadesUser();
        if($request['mensagem']){
            return view('propriedades', ["propriedade"=>$prop, "Tela"=>"Propriedade", 'mensagem'=>$request['mensagem'],'status'=>$request['status']]);
        }else{
            return view('propriedades', ["propriedade"=>$prop, "Tela"=>"Propriedade"]);
        }
    }
    
    public function edit($id){
        $prop = $this->propriedadeService->read($id);
        $tcidade = $this->cidadeService->read($prop->cidade_id);
        $testado = $this->estadoService->read($tcidade->estado_id);
        $estados = $this->estadoService->index();
        return view('propriedadesForm',["propriedade"=>$prop, "mestado"=>$testado, "mcidade"=>$tcidade, 'estados'=>$estados, 'Method'=>'put','Url'=>'/propriedade'.'/'.$id]);
    }
    
    public function update(Request $request, $id){
        if ($request != null and $id != null) {
            $update = $this->propriedadeService->update($request, $id);
            return redirect()->action('PropriedadeController@index', ['mensagem'=>$update['mensagem'],'status'=>$update['status']]);
        }else{
            return redirect()->action('PropriedadeController@index');
        }
    }
}
