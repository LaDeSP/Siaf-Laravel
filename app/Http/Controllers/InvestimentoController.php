<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investimento;

use App\Services\InvestimentoService;
class InvestimentoController extends Controller{
    protected $investimentoService;

    public function __construct(InvestimentoService $investimentoService){
        $this->investimentoService = $investimentoService;
    }

    public function index(Request $request){
        $investimentos = $this->investimentoService->index();
        return view('painel.investimentos.index', ["investimentos" => $investimentos]);

        $propriedade = $this->getPropriedade($request);
        $investimento = Investimento::ler('propriedade_id', $propriedade->id);
        if(!$investimento){
            return redirect()->action('InvestimentoController@index', ['mensagem'=>$request->mensagem,'status'=>$request->status,'page'=>$this->page()-1]);
        }
        return view('investimento',["propriedade" => $propriedade,"dados" => $investimento, "User"=>$this->getFirstName($this->usuario['name']),"Tela" =>"Investimento"]);
    }
    
    public function store(Request $request){
        if ($request != null) {
            $investimento = Investimento::insere($request->all());
            if($investimento == 200){
                $status='success';
                $mensagem='Sucesso ao salvar o investimento!';
            }else{
                $status='danger';
                $mensagem='Erro ao salvar o investimento!';
            }
            $propriedade = $this->getPropriedade($request);
            $investimento = Investimento::ler('propriedade_id', $propriedade->id);
            //return view('investimento',["propriedade" => $propriedade,"dados" => $investimento, "User"=>$this->getFirstName( $this->usuario['nome']) , "Tela"=>"Investimentos",'mensagem'=>$mensagem,'status'=>$status]);
            return redirect()->action('InvestimentoController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
        }else{
            return 405;
        }
    }


    public function show($id= null,$variable=null){
        return Investimento::ler($id, $variable);
    }

    public function update(Request $request, $id){
        if ($request != null) {
            $investimento = Investimento::alterar($request, $id);
            if($investimento == 200){
                $status='success';
                $mensagem='Sucesso ao editar o investimento!';
            }else{
                $status='danger';
                $mensagem='Erro ao editar o investimento!';
            }
            $propriedade = $this->getPropriedade($request);
            $investimento = Investimento::ler('propriedade_id', $propriedade->id);
            return redirect()->action('InvestimentoController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
            //return view('investimento', ["propriedade" => $propriedade,"dados" => $investimento, "User"=>$this->getFirstName($this->usuario['name']),"Tela" =>"Investimentos",'mensagem'=>$mensagem,'status'=>$status]);
        }else{
            return 405;
        }
    }

    public function destroy(Request $request,$id){
        if ($id != null) {
            $investimento = Investimento::excluir($id);
            if($investimento == 200){
                $status='success';
                $mensagem='Sucesso ao excluir o investimento!';
            }else{
                $status='danger';
                $mensagem='Erro ao excluir o investimento!';
            }
            $propriedade = $this->getPropriedade($request);
            $investimento = Investimento::ler('propriedade_id', $propriedade->id);
            //return view('investimento',["propriedade" => $propriedade,"dados" => $investimento, "User"=>$this->getFirstName($this->usuario['name']) , "Tela"=>"Investimentos",'mensagem'=>$mensagem,'status'=>$status]);
            return redirect()->action('InvestimentoController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
        }
        return 405;
    }
}
