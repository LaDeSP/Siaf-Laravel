<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 01 Oct 2019 22:07:44 -0400.
 */

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;


class ManejoPlantio extends Pivot{
	use SoftDeletes;
	use HasHashSlug;
	
	protected $table = 'manejoplantio';

	protected $casts = [
		'horas_utilizadas' => 'int',
		'plantio_id' => 'int',
		'manejo_id' => 'int'
	];

	protected $dates = [
		'data_hora',
		'deleted_at'
	];

	protected $fillable = [
		'descricao',
		'data_hora',
		'horas_utilizadas',
		'plantio_id',
		'manejo_id',
		'deleted_at'
	];

	public function manejo(){
		return $this->belongsTo(\App\Models\Manejo::class);
	}

	public function plantio(){
		return $this->belongsTo(\App\Models\Plantio::class);
	}

	public function estoques(){
		return $this->hasMany(\App\Models\Estoque::class, 'manejoplantio_id');
	}

	public function relatorioManejosPorTalhao($propriedade, $periodo = null){
		if($periodo){
			$tabelaHistorico = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
			->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->join('talhao', 'plantio.talhao_id','=','talhao.id')
			->select('manejo.nome as 1','talhao.nome as 2', 'manejoplantio.data_hora as 3',
			'plantio.data_plantio as 4', 'manejoplantio.horas_utilizadas as 5')
			->whereBetween('manejoplantio.data_hora', [$periodo['dataInicio'], $periodo['dataFim']])
			->where('talhao.propriedade_id', '=', $propriedade->id)
			->groupBy('manejoplantio.id','talhao.id')
			->orderBy('manejoplantio.data_hora','desc')
			->get();
			
			$tabelaResumo = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
			->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->join('talhao', 'plantio.talhao_id','=','talhao.id')
			->select('talhao.nome as 1', (DB::raw('sum(manejoplantio.horas_utilizadas) as \'2\'')))
			->whereBetween('manejoplantio.data_hora', [$periodo['dataInicio'], $periodo['dataFim']])
			->where('talhao.propriedade_id', '=', $propriedade->id)
			->groupBy('talhao.id')->orderBy('2', 'desc')
			->get();
			
		}else{
			$tabelaHistorico = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
			->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->join('talhao', 'plantio.talhao_id','=','talhao.id')
			->select('manejo.nome as 1','talhao.nome as 2', 'manejoplantio.data_hora as 3',
			'plantio.data_plantio as 4', 'manejoplantio.horas_utilizadas as 5')
			->where('talhao.propriedade_id', '=', $propriedade->id)
			->groupBy('manejoplantio.id','talhao.id')
			->orderBy('manejoplantio.data_hora','desc')
			->get();
			
			$tabelaResumo = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
			->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->join('talhao', 'plantio.talhao_id','=','talhao.id')
			->select('talhao.nome as 1', (DB::raw('sum(manejoplantio.horas_utilizadas) as \'2\'')))
			->where('talhao.propriedade_id', '=', $propriedade->id)
			->groupBy('talhao.id')->orderBy('2', 'desc')
			->get();
		}
		return [
			'linhasTabelaHistorico'=>$tabelaHistorico,
			'linhasTabelaResumo'=>$tabelaResumo
		];
	}

	public function relatorioManejosPorPropriedade($propriedade, $periodo = null){
		if($periodo){
			$tabelaHistorico = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
			->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->join('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
			->select('propriedade.nome as 1','manejo.nome as 2', 'manejoplantio.data_hora as 3',
			 'plantio.data_plantio as 4', 'manejoplantio.horas_utilizadas as 5')
			->whereBetween('manejoplantio.data_hora', [$periodo['dataInicio'], $periodo['dataFim']])
			->where('talhao.propriedade_id', '=', $propriedade->id)
			->groupBy('manejoplantio.id', 'talhao.propriedade_id')
			->orderBy('5', 'desc')
			->get();
			
			$tabelaResumo = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
			->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->join('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
			->select('propriedade.nome as 1', 'manejo.nome as 2', (DB::raw('sum(manejoplantio.horas_utilizadas) as \'3\'')))
			->whereBetween('manejoplantio.data_hora', [$periodo['dataInicio'], $periodo['dataFim']])
			->where('talhao.propriedade_id', '=', $propriedade->id)
			->groupBy('manejoplantio.manejo_id', 'talhao.propriedade_id')
			->orderBy('3', 'desc')
			->get();
			
		}else{
			$tabelaHistorico = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
			->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->join('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
			->select('propriedade.nome as 1','manejo.nome as 2', 'manejoplantio.data_hora as 3',
			 'plantio.data_plantio as 4', 'manejoplantio.horas_utilizadas as 5')
			->where('talhao.propriedade_id', '=', $propriedade->id)
			->groupBy('manejoplantio.id', 'talhao.propriedade_id')
			->orderBy('5', 'desc')
			->get();
			
			$tabelaResumo = ManejoPlantio::join('manejo', 'manejoplantio.manejo_id','=','manejo.id')
			->join('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->join('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
			->select('propriedade.nome as 1', 'manejo.nome as 2', (DB::raw('sum(manejoplantio.horas_utilizadas) as \'3\'')))
			->where('talhao.propriedade_id', '=', $propriedade->id)
			->groupBy('manejoplantio.manejo_id', 'talhao.propriedade_id')
			->orderBy('3', 'desc')
			->get();
		}
		return [
			'linhasTabelaHistorico'=>$tabelaHistorico,
			'linhasTabelaResumo'=>$tabelaResumo
		];
	}
}
