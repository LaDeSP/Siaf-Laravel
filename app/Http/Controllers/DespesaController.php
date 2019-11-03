<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Services\DespesaService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\FinancaFormRequest;

class DespesaController extends Controller{
    protected $despesaService;

    public function __construct(DespesaService $despesaService){
        $this->despesaService = $despesaService;
    }

    public function index(){
        $depesas = $this->despesaService->index();
        return view('painel.despesas.index', ["despesas" => $depesas]);
    }
    
    public function create(){
        return view('painel.despesas.create');
    }

    public function store(FinancaFormRequest $request){
        $data = $this->despesaService->create($request->all());
        if($data['class'] == 'success'){
            return Redirect::route('painel.despesa.index')->with($data['class'], $data['mensagem']);
        }else{
            return back()->with($data['class'], $data['mensagem']);
        }
    }

    public function edit(Despesa $despesa){
        return view('painel.despesas.edit', ['despesa'=>$despesa]);
    }

    public function update(FinancaFormRequest $request, Despesa $despesa){
        $data = $this->despesaService->update($request->all(), $despesa);
        return back()->with($data['class'], $data['mensagem']);
    }

    public function destroy(Despesa $despesa){
        $data = $this->despesaService->delete($despesa);
        return $data;
    }
}
