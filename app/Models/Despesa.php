<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 28 Aug 2019 15:56:54 -0400.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Balping\HashSlug\HasHashSlug;

class Despesa extends Eloquent{
	use SoftDeletes;
	use HasHashSlug;
	protected $table = 'despesa';

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
}
