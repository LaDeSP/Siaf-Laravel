<?php

/**
* Created by Reliese Model.
* Date: Sun, 22 Sep 2019 18:39:14 -0400.
*/

namespace App\Models;

use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model as Eloquent;

class Perda extends Eloquent{
	use SoftDeletes;
	protected $table = 'perda';
	
	protected $casts = [
		'quantidade' => 'int',
		'estoque_id' => 'int',
		'manejoplantio_id' => 'int',
		'destino_id' => 'int'
	];
	
	protected $dates = [
		'data'
	];
	
	protected $fillable = [
		'descricao',
		'quantidade',
		'data',
		'estoque_id',
		'manejoplantio_id',
		'destino_id'
	];
	
	public function destino(){
		return $this->belongsTo(\App\Models\Destino::class);
	}
	
	public function estoque(){
		return $this->belongsTo(\App\Models\Estoque::class);
	}
	
	public function manejoplantio(){
		return $this->belongsTo(\App\Models\Manejoplantio::class);
	}
	
	public function relatorioPerdasEstoques($propriedade, $periodo = null){
		if($periodo){
			$tabelaHistorico = Perda::join('destino', 'perda.destino_id','=','destino.id')
			->join('estoque', 'perda.estoque_id','=','estoque.id')
			->leftJoin('produto', 'estoque.produto_id','=','produto.id')
			->select('produto.nome as 1','perda.quantidade as 2', 'perda.data as 3','destino.nome as 4')
			->whereBetween('perda.data', [$periodo['dataInicio'], $periodo['dataFim']])
			->where('estoque.propriedade_id', '=', $propriedade->id)
			->where('destino.tipo', '=', 0)
			->groupBy('perda.id')
			->orderBy('perda.data', 'desc')
			->get();
			
			$tabelaResumo = Perda::join('destino', 'perda.destino_id','=','destino.id')
			->join('estoque', 'perda.estoque_id','=','estoque.id')
			->leftJoin('produto', 'estoque.produto_id','=','produto.id')
			->select((DB::raw('produto.nome as \'1\', SUM(perda.quantidade) as \'2\'' )))
			->whereBetween('perda.data', [$periodo['dataInicio'], $periodo['dataFim']])
			->where('estoque.propriedade_id', '=',$propriedade->id)
			->where('destino.tipo', '=',0)
			->groupBy('produto.id')->orderBy('2', 'desc')
			->get();
		}else{
			$tabelaHistorico = Perda::join('destino', 'perda.destino_id','=','destino.id')
			->join('estoque', 'perda.estoque_id','=','estoque.id')
			->leftJoin('produto', 'estoque.produto_id','=','produto.id')
			->select('produto.nome as 1','perda.quantidade as 2', 'perda.data as 3','destino.nome as 4')
			->where('estoque.propriedade_id', '=', $propriedade->id)
			->where('destino.tipo', '=', 0)
			->groupBy('perda.id')
			->orderBy('perda.data', 'desc')
			->get();
			
			$tabelaResumo = Perda::join('destino', 'perda.destino_id','=','destino.id')
			->join('estoque', 'perda.estoque_id','=','estoque.id')
			->leftJoin('produto', 'estoque.produto_id','=','produto.id')
			->select((DB::raw('produto.nome as \'1\', SUM(perda.quantidade) as \'2\'' )))
			->where('estoque.propriedade_id', '=',$propriedade->id)
			->where('destino.tipo', '=',0)
			->groupBy('produto.id')->orderBy('2', 'desc')
			->get();
		}
		return [
			'linhasTabelaHistorico'=>$tabelaHistorico,
			'linhasTabelaResumo'=>$tabelaResumo
		];
	}
}
