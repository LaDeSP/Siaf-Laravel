<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 28 Aug 2019 17:01:15 -0400.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManejoPlantio extends Pivot{
    use SoftDeletes;
    
	protected $table = 'manejoplantio';

	protected $casts = [
		'horas_utilizadas' => 'int',
		'plantio_id' => 'int',
		'manejo_id' => 'int'
	];

	protected $dates = [
		'data_hora'
	];

	protected $fillable = [
		'id',
		'descricao',
		'data_hora',
		'horas_utilizadas',
		'plantio_id',
		'manejo_id'
	];
    
    public function manejo(){
		return $this->belongsTo(\App\Models\Manejo::class);
	}

	public function plantio(){
		return $this->belongsTo(\App\Models\Plantio::class);
	}

	public function estoques(){
		return $this->hasMany(\App\Models\Estoque::class);
	}
}
