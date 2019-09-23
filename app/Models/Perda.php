<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 22 Sep 2019 18:39:14 -0400.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;

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

	public function destino()
	{
		return $this->belongsTo(\App\Models\Destino::class);
	}

	public function estoque()
	{
		return $this->belongsTo(\App\Models\Estoque::class);
	}

	public function manejoplantio()
	{
		return $this->belongsTo(\App\Models\Manejoplantio::class);
	}
}
