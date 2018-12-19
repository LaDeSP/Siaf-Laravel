<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Despesa;
use App\Models\Investimento;
use App\Models\Propriedade;
use App\Models\Talhao;
use App\Models\Plantio;
use App\Models\ManejoPlantio;
use App\Models\Perda;
use App\Models\Produto;
use App\Models\Estoque;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        // dd($request);
        // if(!(empty($request['interno']))){
            // return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=> $this->$topo, "conteudo"=>$this->$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$this->$lastLine, 'totalG'=> $this->$totalG]);
            // return $this->dat;
     //        // return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$request['todo']['topo'], "conteudo"=>$request['todo']['conteudo']]);
        // }else{
            return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "propriedades" =>$propriedades]);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['tipo'] == "talhão") {
            return $this->talhoes($request);
        }else if ($request['tipo'] == "plantios") {
            return $this->plantios($request);
        }else if ($request['tipo'] == "despesa") {
            return $this->despesas($request);
        } else if($request['tipo'] == "vendas"){
             return $this->vendas($request); 
        }else if ($request['tipo'] == "investimentos") {
            return $this->investimentos($request);
        }else if ($request['tipo'] == "manejo-talhão") {
            return $this->manejosTalhao($request);
        }else if($request['tipo'] == "perdas"){
            return $this->perdas($request);
        }else if ($request['tipo'] == "manejo-propriedade") {
            return $this->manejosPropriedade($request);
        }else if ($request['tipo'] == "colheitas") {
            return $this->colheitas($request);
        }else if ($request['tipo'] == "produtos-ativos-e-não-propriedade") {
            return $this->produtosAtivosEnaoPropriedade($request); /*a fazer */
        }else if ($request['tipo'] == "historico-manejo-plantio") {
            return $this->historicoManejoPlantio($request);
        }else if ($request['tipo'] == "estoque-propriedade") {
            return $this->estoquePropriedade($request);
        }
        return 405;
    }

    function vendas(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Produto','Quantidade', 'Valor','Total','Data','Nota','Destino'];
        $lastLine= ['Produto','Total','Total Unidade'];
        $formatDataTopo= ['Data'];
        $formatDataLast= [];
        $data = Venda::join('destino', 'venda.destino_id','=','destino.id')
        ->join('estoque', 'venda.estoque_id','=','estoque.id')
        ->leftJoin('produto', 'estoque.produto_id','=','produto.id')
        ->select('produto.nome as Produto','venda.quantidade as Quantidade', 'venda.valor_unit as Valor', 'venda.data as Data', 'venda.nota as Nota','destino.nome as Destino', (DB::raw('sum(venda.quantidade * venda.valor_unit) as Total')))
        ->whereBetween('venda.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->where('destino.tipo', '=',1)
        ->groupBy('venda.id')
        ->get();
        $totalG= Venda::join('destino', 'venda.destino_id','=','destino.id')
        ->join('estoque', 'venda.estoque_id','=','estoque.id')
        ->leftJoin('produto', 'estoque.produto_id','=','produto.id')
        ->select((DB::raw('produto.nome as produto, SUM(venda.quantidade * venda.valor_unit) as total, SUM(venda.quantidade) as total_unidade' )))
        ->whereBetween('venda.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->where('destino.tipo', '=',1)
        ->groupBy('produto.id')->orderBy('total', 'desc')
        ->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);
        // return redirect()->action("RelatorioController@index",["tipo"=>$request["tipo"], "date-inicio"=>$request['date-inicio'], "date-final"=>$request['date-final'], "interno"=>true]);

        //    $v = Venda::with(['estoque_id', 'quantidade'])
        //                 ->whereBetween('data', [$request['date-inicio'], $request['date-fim']])
        //                 ->select(DB::raw('*'));
        // $todo = array("topo"=>["Estoque","Quantidade"],"conteudo"=>$v);
        // return redirect()->action("RelatorioController@index",["todo" => $todo]);
    }
    function investimentos(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Investimento','Descrição','Data', 'Quntidade','Valor Unitário'];
        $lastLine= ['Total',' Total Quantidade'];
        $formatDataTopo= ['Data'];
        $formatDataLast= [];
        $data = Investimento::select('investimento.nome as Investimento','investimento.descricao as Descrição','investimento.data as Data', 'investimento.quantidade as Quntidade','investimento.valor_unit as Valor Unitário', (DB::raw('sum(valor_unit*quantidade) as Total')))->whereBetween('investimento.data', [$request['date-inicio'], $request['date-final']])->where('propriedade_id', '=',$propriedade->id)->groupBy('id')->get();
        $totalG= Investimento::select((DB::raw(' SUM(valor_unit*quantidade) as total, SUM(quantidade) as total_quantidade')))->whereBetween('investimento.data', [$request['date-inicio'], $request['date-final']])->where('propriedade_id', '=',$propriedade->id)->orderBy('total', 'desc')->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);
    }
    function despesas(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Despesa', 'Quantidade', 'Data','Valor Unitário','Total',  'Descrição'];
        $lastLine= ['Total','Total Quantidade'];
        $formatDataTopo= ['Data'];
        $formatDataLast= [];
        $data = Despesa::select('despesa.nome as Despesa', 'despesa.quantidade as Quantidade','despesa.valor_unit as Valor Unitário', 'despesa.data as Data', 'despesa.descricao as Descrição', (DB::raw('sum(valor_unit*quantidade) as Total')))->whereBetween('despesa.data', [$request['date-inicio'], $request['date-final']])->where('propriedade_id', '=',$propriedade->id)->groupBy('id')->get();
        $totalG= Despesa::select((DB::raw(' SUM(valor_unit*quantidade) as total, SUM(quantidade) as total_quantidade')))->whereBetween('despesa.data', [$request['date-inicio'], $request['date-final']])->where('propriedade_id', '=',$propriedade->id)->orderBy('total', 'desc')->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);
    }
    function talhoes(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Propriedade','Talhão', 'Área'];
        $lastLine= ['Propriedade', 'Área Total'];
        $formatDataTopo= [];
        $formatDataLast= [];
        $data = Talhao::join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
        ->select('propriedade.nome as Propriedade', 'talhao.nome as Talhão', 'talhao.area as Área')
        ->where('talhao.propriedade_id', '=',$request['propriedade_id'])
        ->groupBy('talhao.id')
        ->get();
        $totalG= Talhao::join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
        ->select(DB::raw('SUM(talhao.area) as area_total, propriedade.nome as propriedade'))
        ->where('talhao.propriedade_id', '=',$request['propriedade_id'])
        ->groupBy('talhao.propriedade_id')
        ->orderBy('area_total', 'desc')
        ->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);
    }
    function plantios(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Produto','Talhão', 'Unidade', 'Plantio', 'Semeadura'];
        $lastLine= ['Produto','Total Unidade'];
        $formatDataTopo= ['Plantio', 'Semeadura'];
        $formatDataLast= [];
        $data = Plantio::join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('produto', 'plantio.produto_id','=','produto.id')
        ->select('produto.nome as Produto','talhao.id as Talhão','plantio.quantidade_pantas as Unidade','plantio.data_plantio as Plantio','plantio.data_semeadura as Semeadura')
        ->whereBetween('plantio.data_plantio', [$request['date-inicio'], $request['date-final']])
        ->where('talhao.propriedade_id', '=',$propriedade->id)
        ->groupBy('plantio.id','talhao.id')->get()/*->paginate(5)*/;
        $totalG= Plantio::join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('produto', 'plantio.produto_id','=','produto.id')
        ->select('produto.nome as produto',(DB::raw('SUM( plantio.quantidade_pantas) as total_unidade')))
        ->whereBetween('plantio.data_plantio', [$request['date-inicio'], $request['date-final']])
         ->where('talhao.propriedade_id', '=',$propriedade->id)
        ->groupBy('plantio.produto_id')->orderBy('total_unidade', 'desc')
        ->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);
    }
    function manejosTalhao(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Manejo','Talhão','Plantio','Tempo gasto', 'Data', 'Descrição'];
        $lastLine= ['Talhão', 'Tempo total gasto'];
        $formatDataTopo= ['Plantio','Data'];
        $formatDataLast= [];
        $data = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->select('manejo.nome as Manejo','talhao.nome as Talhão','plantio.data_plantio as Plantio','manejoplantio.horas_utilizadas as Tempo gasto','manejoplantio.data_hora as Data','manejoplantio.descricao as Descrição')
        ->whereBetween('manejoplantio.data_hora', [$request['date-inicio'], $request['date-final']])
        ->where('talhao.propriedade_id', '=', $propriedade->id)
        ->groupBy('manejoplantio.id','talhao.id')
        ->get();
        $totalG=ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->select('talhao.nome as talhao',(DB::raw('SUM(manejoplantio.horas_utilizadas) as tempo_total_gasto')))
        ->whereBetween('manejoplantio.data_hora', [$request['date-inicio'], $request['date-final']])
        ->where('talhao.propriedade_id', '=', $propriedade->id)
        ->groupBy('talhao.id')->orderBy('tempo_total_gasto', 'desc')
        ->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);
    }
    function perdas(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Produto','Quantidade','Data','Destino', 'Descrição'];
        $lastLine= ['Produto', 'Total Unidade'];
        $formatDataTopo= ['Data'];
        $formatDataLast= [];
        $data = Perda::join('destino', 'perda.destino_id','=','destino.id')
        ->join('estoque', 'perda.estoque_id','=','estoque.id')
        ->leftJoin('produto', 'estoque.produto_id','=','produto.id')
        ->select('produto.nome as Produto','perda.quantidade as Quantidade', 'perda.data as Data','destino.nome as Destino','perda.descricao as Descrição')
        ->whereBetween('perda.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->where('destino.tipo', '=', 0)
        ->groupBy('perda.id')
        ->get();
        $totalG= Perda::join('destino', 'perda.destino_id','=','destino.id')
        ->join('estoque', 'perda.estoque_id','=','estoque.id')
        ->leftJoin('produto', 'estoque.produto_id','=','produto.id')
        ->select((DB::raw('produto.nome as produto, SUM(perda.quantidade) as total_unidade' )))
        ->whereBetween('perda.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=',$propriedade->id)
        ->where('destino.tipo', '=',0)
        ->groupBy('produto.id')->orderBy('total_unidade', 'desc')
        ->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);
    }
    function manejosPropriedade(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        // $propriedade = $this->getPropriedade($request);
        $topo = ['Propriedade','Manejo','Data do Plantio','Tempo gasto', 'Data do Manejo','Descrição'];
        $lastLine= ['Propriedade','Manejo', 'Tempo total gasto'];
        $formatDataTopo= ['Data do Plantio','Data do Manejo'];
        $formatDataLast= [];
        $data = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
        ->select('propriedade.nome as Propriedade','manejo.nome as Manejo','plantio.data_plantio as Data do Plantio','manejoplantio.horas_utilizadas as Tempo Gasto','manejoplantio.data_hora as Data do Manejo','manejoplantio.descricao as Descrição')
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
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);
    }
    function colheitas(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Produto','Data do Manejo','Colhidos','Talhão','Descrição'];
        $lastLine= ['Produto','Total colhidos'];
        $formatDataTopo= ['Data do Manejo'];
        $formatDataLast= [];
        $data = ManejoPlantio::LeftJoin('estoque', 'manejoplantio.id','=','estoque.manejoplantio_id')
        ->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('produto', 'plantio.produto_id','=','produto.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->select('produto.nome as Produto','manejoplantio.data_hora as Data do Manejo','estoque.quantidade as Colhidos', 'talhao.nome as Talhão', 'manejoplantio.descricao as Descrição')
        ->whereBetween('manejoplantio.data_hora', [$request['date-inicio'], $request['date-final']])
        ->where('produto.propriedade_id', '=', $propriedade->id)
        ->where('manejo.nome', '=', 'Colheita')
        ->groupBy('manejoplantio.id')
        ->get();
        $totalG=ManejoPlantio::join('estoque', 'manejoplantio.id','=','estoque.manejoplantio_id')
        ->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('produto', 'plantio.produto_id','=','produto.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->select('produto.nome as produto', (DB::raw('SUM(estoque.quantidade) as total_colhidos')))
        ->whereBetween('manejoplantio.data_hora', [$request['date-inicio'], $request['date-final']])
        ->where('produto.propriedade_id', '=', $propriedade->id)
        ->where('manejo.nome', '=', 'Colheita')
        ->groupBy('produto.id')
        ->orderBy('total_colhidos', 'desc')
        ->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);
    }
    function produtosAtivosEnaoPropriedade(Request $request){
        /*$propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Propriedade', 'Produto','Plantável','Status'];
        $lastLine= ['Status', 'Total de produtos'];
        $formatDataTopo= [];
        $data = Produto::join('propriedade', 'produto.propriedade_id','=','propriedade.id')
        ->select('propriedade.nome as Propriedade','produto.nome as Produto',(DB::raw('')))
        ->whereBetween('', [$request['date-inicio'], $request['date-final']])
        ->where('.propriedade_id', '=', $propriedade->id)
        ->groupBy('.id')
        ->get();
        $totalG=
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);*/
    }
    function historicoManejoPlantio(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Plantio','Manejo','Produto','Talhão','Quantidade de plantas','Tempo gasto', 'Data do Manejo','Descrição'];
        $lastLine= ['Plantio','Produto','Talhão','Quantidade de plantas', 'Tempo total gasto'];
        $formatDataTopo= ['Plantio','Data do Manejo'];
        $formatDataLast= ['Plantio'];
        $data = ManejoPlantio::join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('produto', 'plantio.produto_id','=','produto.id')
        ->join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->select('plantio.data_plantio as Plantio','manejo.nome as Manejo','produto.nome as Produto','talhao.nome as Talhão','plantio.quantidade_pantas as Quantidade de plantas','manejoplantio.horas_utilizadas as Tempo gasto','manejoplantio.data_hora as Data do Manejo','manejoplantio.descricao as Descrição')
        // ->whereBetween('', [$request['date-inicio'], $request['date-final']])
        ->where('talhao.propriedade_id', '=', $propriedade->id)
        ->groupBy('manejoplantio.plantio_id','manejoplantio.manejo_id')
        ->orderBy('plantio.id','asc')
        ->get();
        $totalG= ManejoPlantio::join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->join('talhao', 'plantio.talhao_id','=','talhao.id')
        ->join('produto', 'plantio.produto_id','=','produto.id')
        ->join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
        ->select('plantio.data_plantio as plantio','produto.nome as produto','talhao.nome as talhao','plantio.quantidade_pantas as quantidade_de_plantas',(DB::raw('SUM(manejoplantio.horas_utilizadas) as tempo_total_gasto')))
        // ->whereBetween('', [$request['date-inicio'], $request['date-final']])
        ->where('talhao.propriedade_id', '=', $propriedade->id)
        ->groupBy('manejoplantio.plantio_id')
        ->orderBy('manejoplantio.plantio_id','asc')
        ->get();
        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);
    }
    function estoquePropriedade(Request $request){
        $propriedades= Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propriedade = $this->getPropriedade($request);
        $topo = ['Propriedade','Plantio','Produto','Talhão','Data','Quantidade','Atual'];
        $lastLine= ['Propriedade','Produto','Total','Total atual' ];
        $formatDataTopo= ['Plantio','Data'];
        $formatDataLast=[];
        $data = Estoque::leftJoin('manejoplantio', 'estoque.manejoplantio_id','=','manejoplantio.id')
        ->leftJoin('plantio', 'manejoplantio.plantio_id','=','plantio.id')
        ->leftJoin('talhao', 'plantio.talhao_id','=','talhao.id')
        // ->leftJoin('venda', 'estoque.id','=','venda.estoque_id')
        // ->leftJoin('perda', 'estoque.id','=','perda.estoque_id')
        ->join('produto', 'estoque.produto_id','=','produto.id')
        ->join('propriedade', 'estoque.propriedade_id','=','propriedade.id')
        ->select('estoque.id as id','propriedade.nome as Propriedade','plantio.data_plantio as Plantio','produto.nome as Produto','talhao.nome as Talhão','estoque.data as Data','estoque.quantidade as Quantidade',(DB::raw('estoque.quantidade as Atual')))
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
        ->select('estoque.produto_id','propriedade.nome as propriedade','produto.nome as produto',DB::raw('SUM(estoque.quantidade) as total'),DB::raw('SUM(estoque.quantidade) as total_atual'))
        ->whereBetween('estoque.data', [$request['date-inicio'], $request['date-final']])
        ->where('estoque.propriedade_id', '=', $request['propriedade_id'])
        ->groupBy('produto.id')
        ->get();
        foreach ($totalG as $key => $value) {
            $pv = (Venda::join('estoque','venda.estoque_id','=','estoque.id')->where('estoque.produto_id','=',$value->produto_id)->where('estoque.propriedade_id','=',$request['propriedade_id'])->whereBetween('estoque.data', [$request['date-inicio'], $request['date-final']])->sum('venda.quantidade'))+(Perda::join('estoque','perda.estoque_id','=','estoque.id')->where('estoque.produto_id','=',$value->produto_id)->where('estoque.propriedade_id','=',$request['propriedade_id'])->whereBetween('estoque.data', [$request['date-inicio'], $request['date-final']])->sum('perda.quantidade'));
            $value->total_atual= $value->total_atual - $pv;
        }

        return view('relatorio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Relatório", "topo"=>$topo, "conteudo"=>$data, "tipo" => $request["tipo"], "inicio"=>$request['date-inicio'], "final"=>$request['date-final'],'lastLine'=>$lastLine, 'totalG'=> $totalG, "propriedades" =>$propriedades, "formatDataTopo" =>$formatDataTopo, "formatDataLast" =>$formatDataLast]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $qual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
