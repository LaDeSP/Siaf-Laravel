<?php

namespace App\Http\Controllers;

use App\Models\Investimento;
use Illuminate\Http\Request;

use App\Services\InvestimentoService;
use App\Http\Requests\FinancaFormRequest;

class InvestimentoController extends Controller{
    protected $investimentoService;

    public function __construct(InvestimentoService $investimentoService){
        $this->investimentoService = $investimentoService;
    }

    public function index(Request $request){
        $investimentos = $this->investimentoService->index();
        return view('painel.investimentos.index', ["investimentos" => $investimentos]);
    }

    public function create(){
        return view('painel.investimentos.create');
    }
    
    public function store(FinancaFormRequest $request){
        $data = $this->investimentoService->create($request->all());
        return back()->with($data['class'], $data['mensagem']);
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
