<?php
namespace App\Services;

use App\Models\Manejo;
use App\Models\Plantio;
use \Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\ManejoPlantio;
use App\Services\UserService;
use Illuminate\Support\Carbon;

class ManejoService{
    private $userService;
    
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    public function index(){
        $manejos = Manejo::all();
        return $manejos;
    }
    
    public function plantios(){
        $talhoes = $this->userService->propriedadesUser()->talhoes()->get();
        $plantios = [];
        foreach($talhoes as $talhao){
            if($talhao->plantios()){
                array_push($plantios, $talhao->plantios);
            }
        }
        $plantios = Arr::collapse($plantios);  
        foreach ($plantios as $plantio) {
            if($plantio->manejos()->wherePivot('deleted_at', null)->first()){
                $plantio->manejo = 1;
            }else{
                $plantio->manejo = 0;
            }
        }
        
        return $plantios;
    }
    
    public function create(array $attributes, Plantio $plantio){
        try {
            $manejoPlantio = new ManejoPlantio;
            $manejoPlantio->descricao = $attributes['descricao'];
            $manejoPlantio->data_hora = $attributes['data_manejo'];
            $manejoPlantio->horas_utilizadas = $attributes['horas_utilizadas'];
            $manejoPlantio->manejo_id = $attributes['manejo'];
            $manejoPlantio->plantio_id = $plantio->id;
            $saved = $manejoPlantio->save();
            if($saved){
                return $data=[
                    'mensagem' => 'Manejo adicionado ao plantio com sucesso!',
                    'class' => 'success'
                ];
            }else{
                return $data=[
                    'mensagem' => 'Erro ao adicionar este manejo ao plantio, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao adicionar este manejo ao plantio, tente novamente!',
                'class' => 'danger'
            ];
        }  
    }
    
    public function read($plantio){
        $manejos = $plantio->manejos()->get();
        $manejosAtivos = [];
        foreach ($manejos as $manejo) {
            if($manejo->pivot->deleted_at == null){
                array_push($manejosAtivos, $manejo);
            }
        }
        if($manejosAtivos){
            foreach ($manejosAtivos as $manejo) {
                if($manejo->pivot->manejo_id == 4){
                    /*Seto uma variavel boolean caso este manejo seja colheita e o mesmo já possua um estoque*/
                    if($manejo->pivot->estoques()->first()){
                        $manejo->estoque = 1;
                    }
                }
            }
            return $manejosAtivos;
        }else{
            return null;
        }
    }
    
    public function update(Request $request, $id){
    }
    
    public function delete($manejo){
        try {
            $status = $manejo->estoques()->first();
            if($status){
                return response()->json(['error'=>'Este manejo já está em uso e não pode ser deletado!']);
            }else{
                $plantio = $manejo->plantio()->first();
                $deleted = $plantio->manejos()->wherePivot('id', $manejo->id)->updateExistingPivot($manejo->manejo_id, ['deleted_at' => Carbon::now()]);
                if($deleted){
                    return response()->json(['success'=>'Manejo deletado com sucesso!']);
                }else{
                    return response()->json(['error'=>'Erro ao deletar manejo, tente novamente!']);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Erro ao deletar manejo, tente novamente!']);
        }
    }
}