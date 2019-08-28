<?php

namespace App\Http\Controllers;

use App\Models\Propriedade;
use App\Models\Talhao;
use Illuminate\Http\Request;

use App\Services\TalhaoService;
class TalhaoController extends Controller{
    protected $talhaoService;

    public function __construct(TalhaoService $talhaoService){
        $this->talhaoService = $talhaoService;
    }
    
    public function index(){
        $talhoes = $this->talhaoService->index();
        return view('painel.talhoes.index', ["talhoes" => $talhoes]);
    }
   
    public function create(Request $request){
        $prop = $this->getPropriedade($request);
        return view('talhaoForm',["propriedade"=>$prop, "Title"=>"Adicionar talhão",'Method'=>'post','Url'=>'/talhao']);
    }

   
    public function store(Request $request){
        if ($request != null) {
            $ret = Talhao::inserir($request);
            if( $ret == 200){
                $status='success';
                $mensagem='Talhão inserido com sucesso!';
            }else{
                $status='danger';
                $mensagem='Ocorreu um erro ao salvar seu talhão!';
            }
            return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status]);// ["propriedade"=>$prop,"talhao"=>$talhao, "unidades"=>Unidade::get(["id","nome"]),"produto"=>$produto, "User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Propriedade", ]);
        }else{
            return redirect("/propriedades");
        }

    }

    
    public function show($id){
        return Talhao::find($id);
    }

   
    public function edit($id){
        $talhao = Talhao::find($id);
        $prop = Propriedade::find($talhao['propriedade_id']);
        return view('talhaoForm',["propriedade"=>$prop, "talhao"=>$talhao, 'Method'=>'put','Url'=>'/talhao'.'/'.$id, "Title"=>"Editar Talhão"]);

    }

   
    public function update(Request $request, $id){
        if ($request != null and $id != null) {
            $ret = Talhao::atualizar($request, $id);
            if( $ret == 200){
                $status='success';
                $mensagem='Talhão atualizado com sucesso!';
            }else{
                $status='danger';
                $mensagem='Ocorreu um erro ao atualizar este talhão!';
            }
            return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status, 'talhao'=>$this->pagetalhao(), 'produto'=>$this->pageproduto()]);// ["propriedade"=>$prop,"talhao"=>$talhao, "unidades"=>Unidade::get(["id","nome"]),"produto"=>$produto, "User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Propriedade", ]);
        }else{
            return redirect()->action('PropriedadeController@index');
        }
    }

   
    public function destroy($id){
        try{
            $t = Talhao::find($id);
            if(!PropriedadeController::findUsageT($t)){
                $t->delete();
                $status='success';
                $mensagem='Talhão removido com sucesso!';
                return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status, 'talhao'=>$this->pagetalhao(), 'produto'=>$this->pageproduto()]);
            }else
                throw new \Exception();
        }catch (\Exception $e){
            $status='danger';
            $mensagem='Ocorreu um erro ao remover este Talhão!';
            return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status]);
        }

    }
}
