<?php
namespace App\Services;

use App\Models\Manejo;
use App\Models\Plantio;
use \Illuminate\Support\Arr;
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
                $manejo->emUso = $this->verificaManejoEmUso($manejo->pivot);
            }
            return $manejosAtivos;
        }else{
            return null;
        }
    }
    
    public function update(array $attributes, ManejoPlantio $manejoPlantio){
        try {
            $attributesPivot = [
                'descricao' => $attributes['descricao'],
                'data_hora' => $attributes['data_manejo'],
                'horas_utilizadas' => $attributes['horas_utilizadas'],
                'manejo_id' => $attributes['manejo']
            ];
            $plantio = $manejoPlantio->plantio()->first();
            $saved = $plantio->manejos()->wherePivot('id', $manejoPlantio->id)->updateExistingPivot($manejoPlantio->manejo_id, $attributesPivot);
            if($saved){
                return $data=[
                    'mensagem' => 'Manejo atualizado com sucesso!',
                    'class' => 'info'
                ];
            }else{
                return $data=[
                    'mensagem' => 'Erro ao atualizar este manejo, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao atualizar este manejo, tente novamente!',
                'class' => 'danger'
            ];
        }
    }
    
    public function delete($manejo){
        try {
            $status = $this->verificaManejoEmUso($manejo);
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

    public function verificaManejoEmUso($manejo){
        if($manejo->estoques()->first()){
            return true;
        }else{
            return false;
        }
    }
}