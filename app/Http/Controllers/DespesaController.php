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
        return view('painel.despesas.index', ["despesas" => $depesas]);
    }
    
    public function create(){
        return view('painel.despesas.create');
    }

    public function store(Request $request){
        $data = $this->despesaService->create($request->all());
        return back()->with($data['class'], $data['mensagem']);
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

    
    public function destroy(Despesa $despesa){
        $data = $this->despesaService->delete($despesa);
        return $data;
    }
}
