<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Aug 2019 14:48:59 -0400.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Balping\HashSlug\HasHashSlug;

class Venda extends Eloquent{
	
	use SoftDeletes;
	use HasHashSlug;
	protected $table = 'venda';

	protected $casts = [
		'quantidade' => 'int',
		'valor_unit' => 'float',
		'destino_id' => 'int',
		'estoque_id' => 'int'
	];

	protected $dates = [
		'data'
	];

	protected $fillable = [
		'quantidade',
		'valor_unit',
		'data',
		'nota',
		'slug',
		'destino_id',
		'estoque_id'
	];

	public function destino(){
		return $this->belongsTo(\App\Models\Destino::class);
	}

	public function estoque(){
		return $this->belongsTo(\App\Models\Estoque::class);
	}
}
