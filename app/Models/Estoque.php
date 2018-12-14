<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Venda;

class Estoque extends Model
{


	use SoftDeletes;

	protected $table = 'estoque';



	protected $casts = [

    protected $table = 'estoque';
    protected $primaryKey = 'ID';
    public $incrementing = false;
]

    protected $casts = [

		'ID' => 'int'
	];

	protected $dates = [
		'Data'=>'date:d-m-Y'
	];

	protected $fillable = [
		'ID'=>'id',
		'Data'=>'data',
		'Quantidade'=>'quantidade',
		'Produto_id'=>'produto_id',
		'Propriedade_id'=>'propriedade_id',
		'Manejoplantio_id'=>'manejoplantio_id'
	];

	public static function produtosDisponiveis($idEstoque ){
		$venda = Venda::all()->where('estoque_id','=',$idEstoque)->sum('quantidade');
		$estoque = Estoque::all()->where('id','=',$idEstoque)->sum('quantidade');
		return $estoque-$venda;



	}


	public static function estoquesPropriedade($idPropriedade){
		 return DB::table('estoque')
			->join('produto', 'estoque.produto_id', '=', 'produto.id')
			->leftJoin('manejoplantio','estoque.manejoplantio_id','=','manejoplantio.id')
			->leftJoin('plantio','plantio.id','=','manejoplantio.plantio_id')
			->leftJoin('talhao','plantio.talhao_id','=','talhao.id')
			->where('estoque.propriedade_id','=',$idPropriedade)
			->where('deleted_at','=',null)
			->get(['estoque.id','estoque.quantidade','estoque.produto_id','produto.nome as nomep','produto.plantavel','data','estoque.propriedade_id','manejoplantio.plantio_id','plantio.data_semeadura','plantio.data_plantio','talhao.nome as nomet','manejoplantio.id as manejo_plantio_id','manejoplantio.descricao','manejoplantio.data_hora']);
	}

	public static function coleheitaPropriedade($idPropriedade ){
		$talhoes=Talhao::all()->where('propriedade_id','=',$idPropriedade);
		$plantios = array();
		foreach ($talhoes as $key => $talhao) {
				$plantio=Plantio::all()->where('talhao_id','=',$talhao->id);
				foreach ($plantio as $key => $value) {
					array_push($plantios,$value);
				}

			}
		$Manejos = array();
		foreach ($plantios as $key => $plantio) {
					$manejo=ManejoPlantio::all()->where('plantio_id','=',$plantio->id)->where('manejo_id','=','4');
					foreach ($manejo as $key => $value) {
						array_push($Manejos,$value);
					}

				}
		return $Manejos;

	}



/*
	public function produto()
	{
		return $this->belongsTo(\App\Models\Produto::class, 'id');
	}

	public function plantio()
	{
		return $this->belongsTo(\App\Models\Plantio::class, 'id');
	}

	public function propriedade()
	{
		return $this->belongsTo(\App\Models\Propriedade::class, 'id');
	}

	public static function inserir($request)
	{
        $estoque = self::firstOrCreate(['ID'=> $request['id'], 'Quantidade' => $request['quantidade'],'Produto' => $request['produto_id'], 'Data' => $request['data'], 'Propriedade' => $request['propriedade_id'], 'Plantio' => $request['plantio_id']]);

        return [$estoque, 200];
	}

	public static function ler($id)
	{
		if ($id == null)
		{
			$estoque = self::all();
			return $estoque;
		}

		$estoque = self::find($id);
		return [$estoque, 200];
	}

	public static function excluir($id){
		if ($id != null)
		{
			$estoque = self::find($id);
		    if (!empty($estoque))
		    {
		    	if ($estoque->forcedelete())
		    	{
		    		return ["Deletado com sucesso!", 200];
		    	}
			}
		}
		return ["Ocorreu um problema.", 403];
	}

	public function setSubEstoque($qtd_venda)
    {
        if ($this->exists)
        {
            $this->attributes['quantidade'] =
                $this->attributes['quantidade'] - $qtd_venda;
            $this->save();
        }
        return $this;
    }*/

}
