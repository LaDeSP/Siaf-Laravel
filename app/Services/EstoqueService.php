<?php
namespace App\Services;

use DateTime;
use DateTimeZone;
use App\Models\Estoque;
use App\Models\Produto;
use \Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\UserService;

class EstoqueService{
    private $userService;
    
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    /*Retorna somente os estoques que tenham quantidade maior que zero*/
    public function indexEstoquesQuantidadeDisponivel(){
        $estoques = $this->userService->propriedadesUser()->estoques()->get();
        $estoquesDisponiveis = [];
        foreach ($estoques as $estoque) {
            $estoque->quantidade = $this->quantidadeDisponivelDeProdutoEstoque($estoque);
            if($estoque->quantidade > 0){
                array_push($estoquesDisponiveis, $estoque);
            }
        }
        return $estoquesDisponiveis;
    }

    public function estoquePlataveisIndex(){
        $estoquesProdutosPlantaveis =  $this->userService->propriedadesUser()->estoques()->get();
        $estoques = [];
        
        foreach($estoquesProdutosPlantaveis as $estoque){
            if($estoque->produto()->whereIn("tipo", ["c_permanente","c_temporaria"])->first()){
                $estoque->quantidade = $this->quantidadeDisponivelDeProdutoEstoque($estoque);
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
                $estoque->quantidade = $this->quantidadeDisponivelDeProdutoEstoque($estoque);
                array_push($estoques, $estoque);
            }
        }
        return $estoques;
    }
    
    public function create(array $attributes, $manejo=null){
        try {
            $estoque = new Estoque;
            /*Estoque para colheita de plantio*/
            if($manejo){
                $date = new DateTime();
                $estoque->manejoplantio_id =  $manejo->id;
                $estoque->data = $date->format('Y-m-d H:i:s');
                $estoque->produto_id =  $manejo->plantio()->first()->produto()->first()->id;
            /*Estoque para produto processado*/    
            }else{
                $estoque->produto_id =  Produto::findBySlugOrFail($attributes['produto'])->id;
                $estoque->data = $attributes['data_estoque'];
            }
            $estoque->quantidade = $attributes['quantidade'];
            $estoque->propriedade_id =  $this->userService->propriedadesUser()->id;
            $saved = $estoque->save();
            if($saved){
                if($estoque->manejoplantio_id){
                    return $data=[
                        'mensagem' => 'Colheita adicionada no estoque com sucesso!',
                        'class' => 'success'
                    ];
                }
                return $data=[
                    'mensagem' => 'Estoque salvo com sucesso!',
                    'class' => 'success'
                ];
            }else{
                if($estoque->manejoplantio_id){
                    return $data=[
                        'mensagem' => 'Erro ao salvar colheita no estoque, tente novamente!',
                        'class' => 'danger'
                    ];
                }
                return $data=[
                    'mensagem' => 'Erro ao salvar estoque, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            if($estoque->manejoplantio_id){
                return $data=[
                    'mensagem' => 'Erro ao salvar colheita no estoque, tente novamente!',
                    'class' => 'danger'
                ];
            }
            return $data=[
                'mensagem' => 'Erro ao salvar estoque, tente novamente!',
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