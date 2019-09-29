<?php
namespace App\Services;

use App\Models\Venda;
use App\Models\Estoque;
use \Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\UserService;

class VendaService{
    private $userService;
    
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    public function index(){
        $estoques = $this->userService->propriedadesUser()->estoques()->get();
        $vendas = [];
        foreach($estoques as $estoque){
            if($estoque->vendas()){
                array_push($vendas, $estoque->vendas);
            }
        }
        return Arr::collapse($vendas);
    }
    
    public function create(array $attributes){
        try {
            $venda = new Venda;
            $venda->quantidade = $attributes['quantidade_venda'];
            $venda->valor_unit =  $attributes['valor_unit'];
            $venda->data = $attributes['data_venda'];
            //$venda->nota =  $attributes['nota'];
            $venda->destino_id =  $attributes['destino'];
            $venda->estoque_id =  Estoque::findBySlugOrFail($attributes['estoque'])->id;
            $saved = $venda->save();
            if($saved){
                return $data=[
                    'mensagem' => 'Venda salva com sucesso!',
                    'class' => 'success'
                ];
            }else{
                return $data=[
                    'mensagem' => 'Erro ao salvar venda, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao salvar venda, tente novamente!',
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