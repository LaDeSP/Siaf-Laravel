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
        $plantios = Arr::collapse($plantios);
        /*Neste trecho calculamos a quantidade atual de plantas disponivel no plantio de produtos de cultura temporaria e permanente*/
        foreach ($plantios as $plantio) {
            $plantio->quantidade_pantas = $this->novaQuantidadePlantio($plantio);
            if($plantio->perdas()->first()){
                /*Seto uma variavel boolean se plantio tiver perda*/
                $plantio->perda = 1; 
            }else if($plantio->manejos()->first()){
                /*Seto uma variavel boolean se plantio tiver pelo menos um manejo*/
                $plantio->manejo = 1;
            }
        }
        return $plantios;
    }
    
    public function create(array $attributes){
        try {
            $plantio = new Plantio;
            $plantio->data_semeadura = $attributes['data_semeadura'];
            $plantio->data_plantio =  $attributes['data_plantio'];
            $plantio->quantidade_pantas = $attributes['numero_plantas'];
            $plantio->talhao_id =  decrypt($attributes['talhao']);
            $plantio->produto_id =  decrypt($attributes['produto']);
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
    
    public function delete($plantio){
        try {
            $deleted = $plantio->delete();
            if($deleted){
                return response()->json(['success'=>'Plantio deletado com sucesso!']);
            }else{
                return response()->json(['error'=>'Erro ao deletar plantio, tente novamente!']);
            }
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Erro ao deletar plantio, tente novamente!']);
        }
    }
    
    /*Função que calcula a quantidade disponivel de plantas para produtos de cultura temporaria*/
    public function quantidadeDisponivelDePlantasTemporarias($plantio){
        /*Soma todas as quantidades de perdas deste plantio*/
        $quantidadePerdas = $plantio->perdas()->sum('quantidade');
        
        /*Retorna somente os manejos com colheita deste plantio*/
        $manejos = $plantio->manejos()->where('manejo_id', 4)->get();
        
        /*Variavel para armazena a quantidade de cada colheita deste plantio que esta armazenada no estoque*/
        $quantidadeColheitaPlantioEstoques = 0;
        
        /*Pecorre a tabela de estoque e soma todas as quantidades de cada estoque deste plantio*/
        foreach ($manejos as $manejo) {
            $quantidadeColheitaPlantioEstoques = $quantidadeColheitaPlantioEstoques+$manejo->pivot->estoques()->sum('quantidade');
        }
        
        /*Quantidade atual do plantio antes do calculo */
        $quantidadeAtualPlantio = $plantio->getOriginal('quantidade_pantas');
        
        /*Calculo para determinar a quantidade do plantio subtraindo da tabelas (Perda e Estoque)*/
        $novaQuantidadePlantio = $quantidadeAtualPlantio - ($quantidadePerdas+$quantidadeColheitaPlantioEstoques);
        
        return $novaQuantidadePlantio;
    }
    
    /*Função que calcula a quantidade disponivel de plantas para produtos de cultura permanente*/
    public function quantidadeDisponivelDePlantasCulturais($plantio){
        /*Soma todas as quantidades de perdas deste plantio*/
        $quantidadePerdas = $plantio->perdas()->sum('quantidade');
        
        /*Quantidade atual do plantio antes do calculo */
        $quantidadeAtualPlantio = $plantio->getOriginal('quantidade_pantas');
        
        /*Calculo para determinar a quantidade do plantio subtraindo da tabela de Perda*/
        $novaQuantidadePlantio = $quantidadeAtualPlantio - $quantidadePerdas;
        
        return $novaQuantidadePlantio;
    }
    
    public function novaQuantidadePlantio($plantio){
        if($plantio->produto->tipo == 'c_temporaria'){
            $novaQuantidadePlantio = $plantio->quantidade_pantas = $this->quantidadeDisponivelDePlantasTemporarias($plantio);
            return $novaQuantidadePlantio;
        }else if($plantio->produto->tipo == 'c_permanente'){
            $novaQuantidadePlantio = $plantio->quantidade_pantas = $this->quantidadeDisponivelDePlantasCulturais($plantio);
            return $novaQuantidadePlantio;
        }
    }
}