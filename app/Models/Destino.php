<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 28 Aug 2019 17:23:45 -0400.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Destino extends Eloquent{
	use SoftDeletes;
	protected $table = 'destino';

	protected $casts = [
		'tipo' => 'int'
	];

	protected $fillable = [
		'nome',
		'tipo'
	];

	public function perdas(){
		return $this->hasMany(\App\Models\Perda::class);
	}

	public function vendas(){
		return $this->hasMany(\App\Models\Venda::class);
	}
}
