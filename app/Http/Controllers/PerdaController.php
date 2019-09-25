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
use App\Services\PlantioService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PerdaPlantioFormRequest;



class PerdaController extends Controller{
    protected $plantioService;

    public function __construct(PlantioService $plantioService){
        $this->plantioService = $plantioService;
    }
    
    public function index(Request $request){
    }
    
    public function createPerdaEstoque(Estoque $estoque){
        $destinosPerda = Destino::all()->where('tipo', 0);
        return view('painel.estoques.create-perda', ['estoque'=>$estoque, 'destinos'=>$destinosPerda]);
    }

    public function createPerdaPlantio(Plantio $plantio){
        $destinosPerda = Destino::all()->where('tipo', 0);
        $plantio->quantidade_pantas = $this->plantioService->novaQuantidadePlantio($plantio);
        return view('painel.plantios.create-perda', ['plantio'=>$plantio, 'destinos'=>$destinosPerda]);
    }

    public function storePerdaEstoque(Request $request, Estoque $estoque){    
        dd('entrei no store de perda para estoque');    
    }
    
    public function storePerdaPlantio(PerdaPlantioFormRequest $request, Plantio $plantio){
        dd($plantio);
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
