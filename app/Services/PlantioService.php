<?php
namespace App\Services;

use App\Models\Plantio;
use \Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\UserService;

class PlantioService{
    private $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function index(){
        $talhoes = $this->userService->propriedadesUser()->talhoes()->get();
        $plantios = [];
        foreach($talhoes as $talhao){
            if($talhao->plantios()){
                array_push($plantios, $talhao->plantios);
            }
        }
        return Arr::collapse($plantios);
    }
    
    public function create(array $attributes){
        try {
            $plantio = new Plantio;
            $plantio->data_semeadura = $attributes['data_semeadura'];
            $plantio->data_plantio =  $attributes['data_plantio'];
            $plantio->quantidade_pantas = $attributes['numero_plantas'];
            $plantio->talhao_id =  $attributes['talhao'];
            $plantio->produto_id =  $attributes['produto'];
            $saved = $plantio->save();
            if($saved){
                return $data=[
                    'mensagem' => 'Plantio salvo com sucesso!',
                    'class' => 'success'
                ];
            }else{
                return $data=[
                    'mensagem' => 'Erro ao salvar plantio, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao salvar plantio, tente novamente!',
                'class' => 'danger'
            ];
        }    
    }
    
    public function read($id){
        //return $this->propriedadeRepository->find($id);
    }
    
    public function update(Request $request, $id){
    }

    public function delete($id){
    }
}