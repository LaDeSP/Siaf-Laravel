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
                return $this->talhoes($request);
            }else if ($request['tipoRelatorio'] == "plantios") {
                return $this->modelRelatorio->plantios($request->all());
            }else if ($request['tipoRelatorio'] == "despesa") {
                return $this->modelRelatorio->despesas($request->all());
            } else if($request['tipoRelatorio'] == "vendas"){
                return $this->vendas($request); 
            }else if ($request['tipoRelatorio'] == "investimentos") {
                return $this->modelRelatorio->investimentos($request->all());
            }else if ($request['tipoRelatorio'] == "manejoTalhao") {
                return $this->manejosTalhao($request);
            }else if($request['tipoRelatorio'] == "perdas"){
                return $this->perdas($request);
            }else if ($request['tipoRelatorio'] == "manejoPropriedade") {
                return $this->manejosPropriedade($request);
            }else if ($request['tipoRelatorio'] == "colheitas") {
                return $this->colheitas($request);
            }else if ($request['tipoRelatorio'] == "produtosAtivosInativos") {
                return $this->produtosAtivosEnaoPropriedade($request); /*a fazer */
            }else if ($request['tipoRelatorio'] == "historicoManejoPlantio") {
                return $this->historicoManejoPlantio($request);
            }else if ($request['tipoRelatorio'] == "estoquePropriedade") {
                return $this->estoquePropriedade($request);
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
    
    function talhoes( $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $request =$request->session()->get('r');
        $topo = ['Propriedade','Talhão', 'Área'];
        $lastLine= ['Propriedade', 'Área Total'];
        $formatDataTopo= [];
        $formatDataLast= [];
        $data = Talhao::join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
        ->select('propriedade.nome as propriedade', 'talhao.nome as talhao', 'talhao.area as area')
        ->where('talhao.propriedade_id', '=',$request['propriedade_id'])
        ->groupBy('talhao.id')
        ->get();
        $totalG= Talhao::join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
        ->select(DB::raw('SUM(talhao.area) as area_total, propriedade.nome as propriedade'))
        ->where('talhao.propriedade_id', '=',$request['propriedade_id'])
        ->groupBy('talhao.propriedade_id')
        ->orderBy('area_total', 'desc')
        ->get();
        return ["topo"=>$topo, "conteudo"=> $data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast];
    }
    
    function manejosTalhao( $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $request =$request->session()->get('r');
        $topo = ['Manejo','Talhão','Data do plantio','Tempo gasto', 'Data do manejo', 'Descrição'];
        $lastLine= ['Talhão', 'Tempo total gasto'];
        $formatDataTopo= ['Data do plantio','Data do manejo'];
        $formatDataLast= [];
        $data = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->select('manejo.nome as manejo','talhao.nome as talhao','plantio.data_plantio as data_do_plantio','manejoplantio.horas_utilizadas as tempo_gasto','manejoplantio.data_hora as data_do_manejo','manejoplantio.descricao as descricao')
        ->whereBetween('manejoplantio.data_hora', [$request['date-inicio'], $request['date-final']])
        ->where('talhao.propriedade_id', '=', $propriedade->id)
        ->groupBy('manejoplantio.id','talhao.id')
        ->orderBy('manejoplantio.data_hora','desc')
        ->get();
        $totalG=ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->select('talhao.nome as talhao',(DB::raw('SUM(manejoplantio.horas_utilizadas) as tempo_total_gasto')))
        ->whereBetween('manejoplantio.data_hora', [$request['date-inicio'], $request['date-final']])
        ->where('talhao.propriedade_id', '=', $propriedade->id)
        ->groupBy('talhao.id')->orderBy('tempo_total_gasto', 'desc')
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
    
    function manejosPropriedade( $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        // $propriedade = $this->getPropriedade($request);
        $request =$request->session()->get('r');
        $topo = ['Propriedade','Manejo','Data do Plantio','Tempo gasto', 'Data do Manejo','Descrição'];
        $lastLine= ['Propriedade','Manejo', 'Tempo total gasto'];
        $formatDataTopo= ['Data do Plantio','Data do Manejo'];
        $formatDataLast= [];
        $data = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
        ->select('propriedade.nome as propriedade','manejo.nome as manejo','plantio.data_plantio as data_do_plantio','manejoplantio.horas_utilizadas as tempo_gasto','manejoplantio.data_hora as data_do_manejo','manejoplantio.descricao as Descrição')
        ->whereBetween('manejoplantio.data_hora', [$request['date-inicio'], $request['date-final']])
        ->where('talhao.propriedade_id', '=', $request['propriedade_id'])
        ->groupBy('manejoplantio.id', 'talhao.propriedade_id')
        ->get();
        $totalG =  ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
        ->select('propriedade.nome as propriedade', 'manejo.nome as manejo', (DB::raw('SUM(manejoplantio.horas_utilizadas) as tempo_total_gasto')))
        ->whereBetween('manejoplantio.data_hora', [$request['date-inicio'], $request['date-final']])
        ->where('talhao.propriedade_id', '=', $request['propriedade_id'])
        ->groupBy('manejoplantio.manejo_id', 'talhao.propriedade_id')
        ->orderBy('tempo_total_gasto', 'desc')
        ->get();
        return ["topo"=>$topo, "conteudo"=> $data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast];
    }
    
    function colheitas( $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $request =$request->session()->get('r');
        $topo = ['Produto','Data do Manejo','Quantidade colhida','Talhão','Descrição'];
        $lastLine= ['Produto','Quantidade total colhida'];
        $formatDataTopo= ['Data do Manejo'];
        $formatDataLast= [];
        $data = ManejoPlantio::join('estoque', 'manejoplantio.id','=','estoque.manejoplantio_id')
        ->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('produto', 'plantio.produto_id','=','produto.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->select('produto.nome as produto','manejoplantio.data_hora as data_do_manejo','estoque.quantidade as quantidade_colhida', 'talhao.nome as talhao', 'manejoplantio.descricao as descricao')
        ->whereBetween('manejoplantio.data_hora', [$request['date-inicio'], $request['date-final']])
        ->where('produto.propriedade_id', '=', $propriedade->id)
        ->where('manejo.nome', '=', 'Colheita')
        ->groupBy('manejoplantio.id')
        ->orderBy('manejoplantio.data_hora','desc')
        ->get();
        $totalG=ManejoPlantio::join('estoque', 'manejoplantio.id','=','estoque.manejoplantio_id')
        ->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('produto', 'plantio.produto_id','=','produto.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->select('produto.nome as produto', (DB::raw('SUM(estoque.quantidade) as quantidade_total_colhida')))
        ->whereBetween('manejoplantio.data_hora', [$request['date-inicio'], $request['date-final']])
        ->where('produto.propriedade_id', '=', $propriedade->id)
        ->where('manejo.nome', '=', 'Colheita')
        ->groupBy('produto.id')
        ->orderBy('quantidade_total_colhida', 'desc')
        ->get();
        return ["topo"=>$topo, "conteudo"=> $data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast];
    }
    
    function produtosAtivosEnaoPropriedade( $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $request =$request->session()->get('r');
        $topo = ['Propriedade', 'Produto','Status'];
        $lastLine= ['Propriedade','Status', 'Total de produtos'];
        $formatDataTopo= [];
        $formatDataLast= [];
        $data = Produto::join('propriedade', 'produto.propriedade_id','=','propriedade.id')
        ->select('propriedade.nome as propriedade','produto.nome as produto',(DB::raw('IF(produto.status = 1, "ativo","inativo") as status')))
        ->where('produto.propriedade_id', '=', $request['propriedade_id'])
        ->groupBy('produto.id','produto.status')
        ->get();
        $totalG=Produto::join('propriedade', 'produto.propriedade_id','=','propriedade.id')
        ->select('propriedade.nome as propriedade',(DB::raw('IF(produto.status = 1, "ativo","inativo") as status')), DB::raw('count(*) as total_de_produtos'))
        ->where('produto.propriedade_id', '=', $request['propriedade_id'])
        ->groupBy('produto.status')
        ->get();
        return ["topo"=>$topo, "conteudo"=> $data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast];
    }
    
    function historicoManejoPlantio( $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $request =$request->session()->get('r');
        $topo = ['Data do plantio','Manejo','Produto','Talhão','Quantidade de plantas','Tempo gasto', 'Data do Manejo','Descrição'];
        $lastLine= ['Data do plantio','Produto','Talhão','Quantidade de plantas', 'Tempo total gasto'];
        $formatDataTopo= ['Data do plantio','Data do Manejo'];
        $formatDataLast= ['Data do plantio'];
        $data = ManejoPlantio::join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('produto', 'plantio.produto_id','=','produto.id')
        ->join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->select('plantio.data_plantio as data_do_plantio','manejo.nome as manejo','produto.nome as produto','talhao.nome as talhao','plantio.quantidade_pantas as quantidade_de_plantas','manejoplantio.horas_utilizadas as tempo_gasto','manejoplantio.data_hora as data_do_manejo','manejoplantio.descricao as descricao')
        // ->whereBetween('', [$request['date-inicio'], $request['date-final']])
        ->where('talhao.propriedade_id', '=', $propriedade->id)
        ->groupBy('manejoplantio.plantio_id','manejoplantio.manejo_id')
        ->orderBy('plantio.id','desc')
        ->get();
        $totalG= ManejoPlantio::join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('produto', 'plantio.produto_id','=','produto.id')
        ->join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->select('plantio.data_plantio as data_do_plantio','produto.nome as produto','talhao.nome as talhao','plantio.quantidade_pantas as quantidade_de_plantas',(DB::raw('SUM(manejoplantio.horas_utilizadas) as tempo_total_gasto')))
        // ->whereBetween('', [$request['date-inicio'], $request['date-final']])
        ->where('talhao.propriedade_id', '=', $propriedade->id)
        ->groupBy('manejoplantio.plantio_id')
        ->orderBy('manejoplantio.plantio_id','asc')
        ->get();
        return ["topo"=>$topo, "conteudo"=> $data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast];
    }
    
    function estoquePropriedade( $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $request =$request->session()->get('r');
        $topo = ['Propriedade','Data do plantio','Produto','Talhão','Data','Entrada','Quantidade atual'];
        $lastLine= ['Propriedade','Produto','Total entrada','Total atual' ];
        $formatDataTopo= ['Data do plantio','Data'];
        $formatDataLast=[];
        $data = Estoque::leftJoin('manejoplantio', 'estoque.manejoplantio_id','=','manejoplantio.id')
        ->leftJoin('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->leftJoin('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('produto', 'estoque.produto_id','=','produto.id')
        ->join('propriedade', 'estoque.propriedade_id','=','propriedade.id')
        ->select('estoque.id as id','propriedade.nome as propriedade','plantio.data_plantio as data_do_plantio','produto.nome as produto','talhao.nome as talhao','estoque.data as data','estoque.quantidade as entrada',(DB::raw('estoque.quantidade as quantidade_atual')))
        ->whereBetween('estoque.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=', $request['propriedade_id'])
        ->groupBy('estoque.id')
        ->get();
        foreach ($data as $key => $value) {
            $value->Atual= $value->Quantidade-(Venda::all()->where('estoque_id','=',$value->id)->sum('quantidade')+Perda::all()->where('estoque_id','=',$value->id)->sum('quantidade'));
        }
        $totalG=Estoque::leftJoin('manejoplantio', 'estoque.manejoplantio_id','=','manejoplantio.id')
        ->leftJoin('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->leftJoin('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('produto', 'estoque.produto_id','=','produto.id')
        ->join('propriedade', 'estoque.propriedade_id','=','propriedade.id')
        ->select('estoque.produto_id','propriedade.nome as propriedade','produto.nome as produto',DB::raw('SUM(estoque.quantidade) as total_entrada'),DB::raw('SUM(estoque.quantidade) as total_atual'))
        ->whereBetween('estoque.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=', $request['propriedade_id'])
        ->groupBy('produto.id')
        ->get();
        foreach ($totalG as $key => $value) {
            $pv = (Venda::join('estoque','venda.estoque_id','=','estoque.id')->where('estoque.produto_id','=',$value->produto_id)->where('estoque.propriedade_id','=',$request['propriedade_id'])->whereBetween('estoque.data', [$request['date-inicio'], $request['date-final']])->sum('venda.quantidade'))+(Perda::join('estoque','perda.estoque_id','=','estoque.id')->where('estoque.produto_id','=',$value->produto_id)->where('estoque.propriedade_id','=',$request['propriedade_id'])->whereBetween('estoque.data', [$request['date-inicio'], $request['date-final']])->sum('perda.quantidade'));
            $value->total_atual= $value->total_atual - $pv;
        }
        
        return ["topo"=>$topo, "conteudo"=> $data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast];
    }
}
