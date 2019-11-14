<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 14 Aug 2019 17:18:51 +0000.
 */

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model as Eloquent;

class Talhao extends Eloquent{
    use SoftDeletes;
    use HasHashSlug;
    protected $table='talhao';

	protected $casts = [
		'area' => 'int',
		'propriedade_id' => 'int'
	];

	protected $fillable = [
		'area',
		'nome',
        'propriedade_id',
	];

	public function propriedade(){
		return $this->belongsTo(\App\Models\Propriedade::class);
	}

	public function plantios(){
		return $this->hasMany(\App\Models\Plantio::class);
	}
	
	public function relatorioTalhoes($propriedade){
			$tabelaHistorico = Talhao::join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
			->select('propriedade.nome as 1', 'talhao.nome as 2', 'talhao.area as 3')
			->where('talhao.propriedade_id', '=',$propriedade->id)
			->groupBy('talhao.id')
			->get();
			
			$tabelaResumo = Talhao::join('propriedade', 'talhao.propriedade_id','=','propriedade.id')
			->select(DB::raw('propriedade.nome as \'1\', sum(talhao.area) as \'2\''))
			->where('talhao.propriedade_id', '=',$propriedade->id)
			->groupBy('talhao.propriedade_id')
			->orderBy('2', 'desc')
			->get();
			
		return [
			'linhasTabelaHistorico'=>$tabelaHistorico,
			'linhasTabelaResumo'=>$tabelaResumo
		];
	}
}
