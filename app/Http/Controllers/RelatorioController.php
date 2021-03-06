<?php

namespace App\Http\Controllers;

use App\Models\Relatorio;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class RelatorioController extends Controller{
    protected $modelRelatorio;
    
    public function __construct(Relatorio $relatorio){
        $this->modelRelatorio = $relatorio;
    }
    
    public function index(){
        return view('painel.relatorios.index');
    }
    
    public function gerarRelatorio(Request $request){
        try {
            $relatorio = $this->tipoRelatorio($request);
            $pdf = PDF::loadView('painel.relatorios.pdf_view', ['relatorio'=>$relatorio]);  
            return $pdf->stream($relatorio['tituloRelatorio'].'.pdf');
        } catch (\Throwable $th) {
            $data = $this->erroRelatorio();
            return back()->with($data['class'], $data['mensagem']);
        }
    }
    
    public function erroRelatorio(){
        return $data=[
            'mensagem' => 'Erro ao gerar relatório, tente novamente!',
            'class' => 'danger'
        ];
    }
    
    function tipoRelatorio($request){
        if ($request['tipoRelatorio'] == "talhao") {
            return $this->modelRelatorio->talhoes();
        }else if ($request['tipoRelatorio'] == "plantios") {
            return $this->modelRelatorio->plantios($request->all());
        }else if ($request['tipoRelatorio'] == "despesa") {
            return $this->modelRelatorio->despesas($request->all());
        } else if($request['tipoRelatorio'] == "vendas"){
            return $this->modelRelatorio->vendas($request->all()); 
        }else if ($request['tipoRelatorio'] == "investimentos") {
            return $this->modelRelatorio->investimentos($request->all());
        }else if ($request['tipoRelatorio'] == "manejoTalhao") {
            return $this->modelRelatorio->relatorioManejosPorTalhao($request->all());
        }else if($request['tipoRelatorio'] == "perdas"){
            return $this->modelRelatorio->perdasEstoques($request->all());
        }else if ($request['tipoRelatorio'] == "manejoPropriedade") {
            return $this->modelRelatorio->relatorioManejosPorPropriedade($request->all());
        }else if ($request['tipoRelatorio'] == "colheitas") {
            return $this->modelRelatorio->colheitas($request->all());
        }else if ($request['tipoRelatorio'] == "produtosAtivosInativos") {
            return $this->modelRelatorio->produtosAtivosEInativos();
        }else if ($request['tipoRelatorio'] == "historicoManejoPlantio") {
            return $this->modelRelatorio->relatorioManejosPorPlantio();
        }else if ($request['tipoRelatorio'] == "estoquePropriedade") {
            return $this->modelRelatorio->estoquesPorPropriedade($request->all());
        }
    }
}
