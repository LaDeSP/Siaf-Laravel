<?php
namespace App\Services;

use App\Models\Manejo;
use App\Models\Plantio;
use \Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\ManejoPlantio;
use App\Services\UserService;

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
        return Arr::collapse($plantios);
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
        if($manejos->isEmpty()){
            return collect([]);
        }else{
            return $manejos;
        }
    }
    
    public function update(Request $request, $id){
    }
    
    public function delete($id){
    }
}