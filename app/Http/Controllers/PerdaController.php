<?php

namespace App\Http\Controllers;

use App\Models\Perda;
use App\Models\Talhao;
use App\Models\Destino;
use App\Models\Estoque;
use App\Models\Plantio;
use App\Models\Produto;
use App\Models\Propriedade;
use Illuminate\Http\Request;
use App\Models\ManejoPlantio;
use Illuminate\Support\Facades\DB;



class PerdaController extends Controller{
    
    
    public function index(Request $request,$id){
        $propriedade=$this->getPropriedade($request);
        $destinos=$destinos = DB::table('destino')
        ->select('destino.id', 'nome AS destino')
        ->where('destino.deleted_at','=',null)
        ->where('destino.tipo','=',0)
        ->get();
        $max=Estoque::produtosDisponiveis($id);
        $estoque=DB::table('estoque')
        ->join('produto', 'estoque.produto_id', '=', 'produto.id')
        ->join('unidade', 'unidade.id', '=', 'produto.unidade_id')
        ->where('estoque.deleted_at','=',null)
        ->where('estoque.id','=',$id)
        ->get(['produto.nome as nomep','unidade.nome as nomeu']);
        $estoque=$estoque->first();
        return view('perdaForm', ["User"=>$this->getFirstName($this->usuario['name']) , "Tela"=>"Perda", 'Url'=>'/perda','Method'=>'post','Estoque'=>$id,'Destinos'=>$destinos,'Max'=>$max,'Produto'=>$estoque->nomep,'Unidade'=>$estoque->nomeu ]);
    }
    
    public function createPerdaEstoque(Estoque $estoque){
        $destinosPerda = Destino::all()->where('tipo', 0);
        return view('painel.estoques.create-perda', ['estoque'=>$estoque, 'destinos'=>$destinosPerda]);
    }

    public function createPerdaPlantio(Plantio $plantio){
        $destinosPerda = Destino::all()->where('tipo', 0);
        return view('painel.plantios.create-perda', ['plantio'=>$plantio, 'destinos'=>$destinosPerda]);
    }

    public function storePerdaEstoque(Request $request, Estoque $estoque){    
        dd('entrei no store de perda para estoque');    
    }
    
    public function storePerdaPlantio(Request $request, Plantio $plantio){
        dd('entrei no store de perda para plantio');
    }
    
    public function page(){
        $query=parse_url(url()->previous());
        if(isset($query['query'])){
            $page=explode('page',$query['query']);
            if(isset($page[1] )){
                $page=explode('=',$page[1]);
                if(isset($page[1]))
                return $page[1];
            }
        }
        return 0;
        
    }
    
}
