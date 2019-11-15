<?php

namespace App\Http\Controllers;

use App\Models\Perda;
use App\Models\Venda;
use App\Models\Talhao;
use App\Models\Despesa;
use App\Models\Destino;
use App\Models\Estoque;
use App\Models\Plantio;
use App\Models\Produto;
use App\Models\Relatorio;
use App\Models\Propriedade;
use App\Models\Investimento;
use Illuminate\Http\Request;
use App\Models\ManejoPlantio;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller{
    protected $modelRelatorio;
    
    public function __construct(Relatorio $relatorio){
        $this->modelRelatorio = $relatorio;
    }
    
    public function index(){
        return view('painel.relatorios.index');
    }
    
    public function gerarRelatorio(Request $request){
        $relatorio = $this->tipoRelatorio($request);
        //dd($relatorio['linhasTabela']);
        if($relatorio != false){
            
            $pdf = PDF::loadView('painel.relatorios.pdf_view', ['relatorio'=>$relatorio]);  
            //$pdf->set_base_path('public/assets');
            return $pdf->stream($relatorio['tituloRelatorio'].'.pdf');
            $data = $this->erroRelatorio();
            return back()->with($data['class'], $data['mensagem']);
            
        }else{
            $data = $this->erroRelatorio();
            return back()->with($data['class'], $data['mensagem']);
        }
        
        $data = $request->all(); 
        $datas = explode("até", $data['dates']);
        dd($datas);
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
            return $this->vendas($request); 
        }else if ($request['tipoRelatorio'] == "investimentos") {
            return $this->modelRelatorio->investimentos($request->all());
        }else if ($request['tipoRelatorio'] == "manejoTalhao") {
            return $this->modelRelatorio->relatorioManejosPorTalhao($request->all());
        }else if($request['tipoRelatorio'] == "perdas"){
            return $this->perdas($request);
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
    
    function vendas($request){
        $propriedade = $this->getPropriedade($request);
        $request =$request->session()->get('r');
        $topo = ['Produto','Quantidade vendida', 'Valor unitário','Total','Data da venda','Nota','Destino'];
        $lastLine= ['Produto','Total','Total quantidade'];
        $formatDataTopo= ['Data da venda'];
        $formatDataLast= [];
        $data = Venda::join('estoque', 'venda.estoque_id','=','estoque.id')
        ->leftJoin('destino', 'venda.destino_id','=','destino.id')
        ->leftJoin('produto', 'estoque.produto_id','=','produto.id')
        ->select('produto.nome as produto','venda.quantidade as quantidade_vendida', 'venda.valor_unit as valor_unitario', 'venda.data as data_da_venda', 'venda.nota as nota','destino.nome as destino', (DB::raw('sum(venda.quantidade * venda.valor_unit) as total')))
        ->whereBetween('venda.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->where('destino.tipo', '=',1)
        ->groupBy('venda.id')
        ->orderBy('venda.data', 'desc')
        ->get();
        $totalG= Venda::join('destino', 'venda.destino_id','=','destino.id')
        ->join('estoque', 'venda.estoque_id','=','estoque.id')
        ->leftJoin('produto', 'estoque.produto_id','=','produto.id')
        ->select((DB::raw('produto.nome as produto, SUM(venda.quantidade * venda.valor_unit) as total, SUM(venda.quantidade) as total_quantidade' )))
        ->whereBetween('venda.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->where('destino.tipo', '=',1)
        ->groupBy('produto.id')
        ->orderBy('total', 'desc')
        ->get();
        return ["topo"=>$topo, "conteudo"=> $data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast];
    }
    
    function perdas( $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $request =$request->session()->get('r');
        $topo = ['Produto','Quantidade perdida','Data','Destino', 'Descrição'];
        $lastLine= ['Produto', 'Quantidade total perdida'];
        $formatDataTopo= ['Data'];
        $formatDataLast= [];
        $data = Perda::join('destino', 'perda.destino_id','=','destino.id')
        ->join('estoque', 'perda.estoque_id','=','estoque.id')
        ->leftJoin('produto', 'estoque.produto_id','=','produto.id')
        ->select('produto.nome as produto','perda.quantidade as quantidade_perdida', 'perda.data as data','destino.nome as destino','perda.descricao as descricao')
        ->whereBetween('perda.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->where('destino.tipo', '=', 0)
        ->groupBy('perda.id')
        ->orderBy('perda.data', 'desc')
        ->get();
        $totalG= Perda::join('destino', 'perda.destino_id','=','destino.id')
        ->join('estoque', 'perda.estoque_id','=','estoque.id')
        ->leftJoin('produto', 'estoque.produto_id','=','produto.id')
        ->select((DB::raw('produto.nome as produto, SUM(perda.quantidade) as quantidade_total_perdida' )))
        ->whereBetween('perda.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->where('destino.tipo', '=',0)
        ->groupBy('produto.id')->orderBy('quantidade_total_perdida', 'desc')
        ->get();
        return ["topo"=>$topo, "conteudo"=> $data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast];
    }
}
