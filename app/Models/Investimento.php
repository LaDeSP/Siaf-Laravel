<?php

/**
* Created by Reliese Model.
* Date: Wed, 28 Aug 2019 15:54:39 -0400.
*/

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Balping\HashSlug\HasHashSlug;

class Investimento extends Eloquent{
	use SoftDeletes;
	use HasHashSlug;
	
	protected $table = 'investimento';
	
	protected $casts = [
		'valor_unit' => 'float',
		'quantidade' => 'int',
		'propriedade_id' => 'int'
	];
	
	protected $dates = [
		'data'
	];
	
	protected $fillable = [
		'nome',
		'descricao',
		'valor_unit',
		'slug',
		'quantidade',
		'data',
		'propriedade_id'
	];
	
	public function propriedade(){
		return $this->belongsTo(\App\Models\Propriedade::class);
	}
	
	public function relatorioInvestimentos($propriedade, $periodo = null){
		if($periodo){
			$tabelaHistorico = $propriedade->investimentos()->groupBy('id')->orderBy('created_at', 'desc')
			->whereBetween('data', [$periodo['dataInicio'], $periodo['dataFim']])
			->selectRaw('nome as \'1\', data as \'2\', quantidade as \'3\', valor_unit as \'4\', sum(valor_unit*quantidade) as \'5\'')
			->get();

			$tabelaResumo = $propriedade->investimentos()->groupBy('id')->orderBy('created_at', 'desc')
			->whereBetween('data', [$periodo['dataInicio'], $periodo['dataFim']])
			->selectRaw('sum(valor_unit*quantidade) as \'1\'')
			->selectRaw('sum(quantidade) as \'2\'')
			->get();
		}else{
			$tabelaHistorico = $propriedade->investimentos()->groupBy('id')->orderBy('created_at', 'desc')
			->selectRaw('nome as \'1\', data as \'2\', quantidade as \'3\', valor_unit as \'4\', sum(valor_unit*quantidade) as \'5\'')
			->get();
			
			$tabelaResumo = $propriedade->investimentos()->groupBy('id')->orderBy('created_at', 'desc')
			->selectRaw('sum(valor_unit*quantidade) as \'1\'')
			->selectRaw('sum(quantidade) as \'2\'')
			->get();
		}
		$tabelaResumo = ['1' =>$tabelaResumo->sum('1'), '2'=>$tabelaResumo->sum('2')];
		return [
			'linhasTabelaHistorico'=>$tabelaHistorico,
			'linhasTabelaResumo'=>$tabelaResumo
		];
	}
}
