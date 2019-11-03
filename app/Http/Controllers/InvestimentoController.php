<?php

namespace App\Http\Controllers;

use App\Models\Investimento;
use Illuminate\Http\Request;
use App\Services\InvestimentoService;
use Illuminate\Support\Facades\Redirect;
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
        if($data['class'] == 'success'){
            return Redirect::route('painel.investimento.index')->with($data['class'], $data['mensagem']);
        }else{
            return back()->with($data['class'], $data['mensagem']);
        }
    }

    public function edit(Investimento $investimento){
        return view('painel.investimentos.edit', ['investimento'=>$investimento]);
    }

    public function update(FinancaFormRequest $request, Investimento $investimento){
        $data = $this->investimentoService->update($request->all(), $investimento);
        return back()->with($data['class'], $data['mensagem']);
    }

    public function destroy(Investimento $investimento){
        $data = $this->investimentoService->delete($investimento);
        return $data;
    }
}
