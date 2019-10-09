<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 01 Oct 2019 22:07:44 -0400.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Balping\HashSlug\HasHashSlug;


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
}
