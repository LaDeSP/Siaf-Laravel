<?php
namespace App\Services;

use App\Models\Perda;

class PerdaService{
    
    public function create(array $attributes, $plantio=null, $estoque=null){
        try {
            $perda = new Perda;
            $perda->descricao = $attributes['descricao'];
            $perda->quantidade =  $attributes['quantidade_perda'];
            $perda->data = $attributes['data_perda'];
            $perda->destino_id =  $attributes['destino'];
            if($plantio){
                $perda->plantio_id =  $plantio->id;
            }else{
                $perda->estoque_id =  $estoque->id;
            }
            $saved = $perda->save();
            if($saved){
                return $data=[
                    'mensagem' => 'Perda salvo com sucesso!',
                    'class' => 'success'
                ];
            }else{
                return $data=[
                    'mensagem' => 'Erro ao salvar perda, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao salvar perda, tente novamente!',
                'class' => 'danger'
            ];
        }
    }
}