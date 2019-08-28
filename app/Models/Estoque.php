<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Aug 2019 15:12:45 -0400.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Venda;
use App\Models\Perda;

class Estoque extends Eloquent{
	
	use SoftDeletes;
	protected $table = 'estoque';

	protected $casts = [
		'quantidade' => 'int',
		'produto_id' => 'int',
		'propriedade_id' => 'int',
		'manejoplantio_id' => 'int'
	];

	protected $dates = [
		'data'
	];

	protected $fillable = [
		'quantidade',
		'produto_id',
		'data',
		'slug',
		'propriedade_id',
		'manejoplantio_id'
	];

	public function manejoplantio(){
		return $this->belongsTo(\App\Models\Manejoplantio::class);
	}

	public function produto(){
		return $this->belongsTo(\App\Models\Produto::class);
	}

	public function propriedade(){
		return $this->belongsTo(\App\Models\Propriedade::class);
	}

	public function perdas(){
		return $this->hasMany(\App\Models\Perda::class);
	}

	public function vendas(){
		return $this->hasMany(\App\Models\Venda::class);
	}

	public static function produtosDisponiveis($idEstoque ){
		$venda = Venda::all()->where('estoque_id','=',$idEstoque)->sum('quantidade');
		$perda = Perda::all()->where('estoque_id','=',$idEstoque)->sum('quantidade');
		$estoque = Estoque::all()->where('id','=',$idEstoque)->sum('quantidade');
		return $estoque-($venda+$perda);
	}


	public static function estoquesPropriedade($idPropriedade){
		 return DB::table('estoque')
			->join('produto', 'estoque.produto_id', '=', 'produto.id')
			->join('unidade', 'unidade.id', '=', 'produto.unidade_id')
			->leftJoin('manejoplantio','estoque.manejoplantio_id','=','manejoplantio.id')
			->leftJoin('plantio','plantio.id','=','manejoplantio.plantio_id')
			->leftJoin('talhao','plantio.talhao_id','=','talhao.id')
			->where('estoque.propriedade_id','=',$idPropriedade)
			->where('estoque.deleted_at','=',null)
			->orderBy('data', 'ASC')
			->get(['estoque.id','estoque.quantidade','estoque.produto_id','produto.nome as nomep','unidade.nome as unidade','produto.plantavel','data','estoque.propriedade_id','manejoplantio.plantio_id','plantio.data_semeadura','plantio.data_plantio','talhao.nome as nomet','manejoplantio.id as manejo_plantio_id','manejoplantio.descricao','manejoplantio.data_hora']);
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
}
