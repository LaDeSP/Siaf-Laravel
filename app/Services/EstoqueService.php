<?php
namespace App\Services;

use App\Models\Estoque;
use \Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\UserService;

class EstoqueService{
    private $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function estoquePlataveisIndex(){
        $estoquesProdutosPlantaveis =  $this->userService->propriedadesUser()->estoques()->get();
        $estoques = [];

        foreach($estoquesProdutosPlantaveis as $estoque){
            if($estoque->produto()->whereIn("tipo", ["c_permanente","c_temporaria"])->first()){
                array_push($estoques, $estoque);
            }
        }
        return $estoques;
    }

    public function estoqueProcessadoIndex(){
        $estoquesProdutosPropriedade =  $this->userService->propriedadesUser()->estoques()->get();
        $estoques = [];
        foreach($estoquesProdutosPropriedade as $key => $estoque){
            if($estoque->produto()->where("tipo","processado")->first()){
                array_push($estoques, $estoque);
            }
        }
        return $estoques;
    }
    
    public function create(array $attributes){
        try {
            $perda = new Estoque;
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
    
    public function read($id){
        //return $this->propriedadeRepository->find($id);
    }
    
    public function update(Request $request, $id){
    }

    public function delete($id){
    }

    /*Função que calcula a quantidade disponivel do produto estocado*/
    public static function quantidadeDisponivelDeProdutoEstoque($estoque){
        /*Soma todas as quantidades de vendas deste estoque*/
        $quantidadeProdutoVenda = $estoque->vendas()->sum('quantidade');

        /*Soma todas as quantidades de perdas deste estoque*/
        $quantidadeProdutoPerdas = $estoque->perdas()->sum('quantidade');

        /*Quantidade atual do estoque antes do calculo */
        $quantidadeAtualEstoque = $estoque->getOriginal('quantidade');

        /*Calculo para determinar a quantidade do produto no estoque subtraindo da tabela de venda e perda*/
        $novaQuantidadeEstoque = $quantidadeAtualEstoque - ($quantidadeProdutoVenda + $quantidadeProdutoPerdas);
        return $novaQuantidadeEstoque;
	}
}