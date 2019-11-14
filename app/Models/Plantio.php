<?php

/**
* Created by Reliese Model.
* Date: Mon, 23 Sep 2019 10:48:24 -0400.
*/

namespace App\Models;

use Illuminate\Support\Carbon;
use Balping\HashSlug\HasHashSlug;
use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model as Eloquent;

class Plantio extends Eloquent{
	use SoftDeletes;
	use HasHashSlug;
	protected $table = 'plantio';
	
	protected $casts = [
		'quantidade_pantas' => 'int',
		'talhao_id' => 'int',
		'produto_id' => 'int'
	];
	
	protected $dates = [
		'data_semeadura',
		'data_plantio'
	];
	
	protected $fillable = [
		'id',
		'data_semeadura',
		'data_plantio',
		'quantidade_pantas',
		'talhao_id',
		'produto_id'
	];
	
	public function produto(){
		return $this->belongsTo(\App\Models\Produto::class);
	}
	
	public function talhao(){
		return $this->belongsTo(\App\Models\Talhao::class);
	}
	
	public function manejos(){
		return $this->belongsToMany(\App\Models\Manejo::class, 'manejoplantio')
		->withTimestamps()
		->withPivot(['id', 'descricao', 'data_hora', 'horas_utilizadas', 'created_at', 'updated_at', 'deleted_at'])
		->using(\App\Models\ManejoPlantio::class);
		
	}
	
	public function perdas(){
		return $this->hasMany(\App\Models\Perda::class);
	}
	
	public function relatorioPlantios($propriedade, $periodo = null){
		if($periodo){
			$tabelaHistorico = Plantio::join('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('produto', 'plantio.produto_id','=','produto.id')
			->select('produto.nome as 1', 'plantio.quantidade_pantas as 2',
					'talhao.nome as 3','plantio.data_plantio as 4',
					'plantio.data_semeadura as 5')
			->whereBetween('plantio.data_plantio', [$periodo['dataInicio'], $periodo['dataFim']])
			->where('talhao.propriedade_id', $propriedade->id)
			->where('plantio.deleted_at', null)
			->orderBy('plantio.data_plantio', 'desc')
			->groupBy('plantio.id','talhao.id')->get();
			
			$tabelaResumo = Plantio::join('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('produto', 'plantio.produto_id','=','produto.id')
			->select('produto.nome as 1', (DB::raw('sum( plantio.quantidade_pantas) as \'2\'')))
			->whereBetween('plantio.data_plantio', [$periodo['dataInicio'], $periodo['dataFim']])
			->groupBy('plantio.produto_id')->orderBy('2', 'desc')
			->where('talhao.propriedade_id', $propriedade->id)
			->where('plantio.deleted_at', null)->get();
			
		}else{
			$tabelaHistorico = Plantio::join('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('produto', 'plantio.produto_id','=','produto.id')
			->select('produto.nome as 1', 'plantio.quantidade_pantas as 2',
					'talhao.nome as 3','plantio.data_plantio as 4',
					'plantio.data_semeadura as 5')
			->where('talhao.propriedade_id', $propriedade->id)
			->where('plantio.deleted_at', null)
			->orderBy('plantio.data_plantio', 'desc')
			->groupBy('plantio.id','talhao.id')->get();
			
			$tabelaResumo = Plantio::join('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('produto', 'plantio.produto_id','=','produto.id')
			->select('produto.nome as 1', (DB::raw('sum( plantio.quantidade_pantas) as \'2\'')))
			->groupBy('plantio.produto_id')->orderBy('2', 'desc')
			->where('talhao.propriedade_id', $propriedade->id)
			->where('plantio.deleted_at', null)->get();
		}
		return [
			'linhasTabelaHistorico'=>$tabelaHistorico,
			'linhasTabelaResumo'=>$tabelaResumo
		];
	}
}
