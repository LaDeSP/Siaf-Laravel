<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Despesa;

use App\Services\DespesaService;
class DespesaController extends Controller{
    protected $despesaService;

    public function __construct(DespesaService $despesaService){
        $this->despesaService = $despesaService;
    }

    public function index(Request $request){
        $depesas = $this->despesaService->index();
        return view('painel.despesas.index', ["depesas" => $depesas]);

        $propriedade = $this->getPropriedade($request);
        $despesas = Despesa::ler('propriedade_id', $propriedade->id);
        if(!$despesas)
          return redirect()->action('DespesaController@index', ['mensagem'=>$request->mensagem,'status'=>$request->status,'page'=>$this->page()-1]);
        return view('despesa', ["propriedade" => $propriedade, "dados" => $despesas,"User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Despesa",'mensagem'=>$request->mensagem,'status'=>$request->status]);
    }

    
    public function create(){
        //
    }

    
    public function store(Request $request){
        if ($request != null) {
            $propriedade = $this->getPropriedade($request);
            $despesa =  Despesa::inserir($request->all());
            $despesas = Despesa::ler('propriedade_id', $propriedade->id);
            if ($despesa == 200) {
                $status='success';
                $mensagem='Sucesso ao salvar a despesa!';
            }else{
                $status='danger';
                $mensagem='Sucesso ao salvar a despesa';
            }
            return redirect()->action('DespesaController@index', ['mensagem'=>$mensagem,'status'=>$status]);
        }else{
            return 405;
        }
    }

    public function show($id=null,$variable=null){
        return Despesa::ler($id, $variable);
    }

    
    public function edit($id){
        //
    }

    
    public function update(Request $request, $id){
        if ($request != null) {
            $propriedade = $this->getPropriedade($request);
            $despesa =  Despesa::alterar($request, $id);
            $despesas = Despesa::ler('propriedade_id', $propriedade->id);
            if ($despesa == 200) {
                $status='success';
                $mensagem='Sucesso ao editar a despesa!';
            }else{
                $status='danger';
                $mensagem='Sucesso ao editar a despesa';
            }
            return redirect()->action('DespesaController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
        }else{
            return 405;
        }
    }

    
    public function destroy(Request $request, $id){
        if ($id != null) {
            $propriedade = $this->getPropriedade($request);
            $despesa =  Despesa::excluir($id);
            $despesas = Despesa::ler('propriedade_id', $propriedade->id);
            if ($despesa == 200) {
                $status='success';
                $mensagem='Sucesso ao excluir a despesa!';
            }else{
                $status='danger';
                $mensagem='Sucesso ao excluir a despesa';
            }
            return redirect()->action('DespesaController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
            //return view('despesa', ["propriedade" => $propriedade, "dados" => $despesas,"User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Despesas", "status" => $status, "mensagem" => $mensagem]);
        }
        return 405;
    }
}
