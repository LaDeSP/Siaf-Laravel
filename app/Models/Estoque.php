<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Aug 2019 15:12:45 -0400.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Balping\HashSlug\HasHashSlug;

class Estoque extends Eloquent{
	use SoftDeletes;
	use HasHashSlug;
	protected $table = 'estoque';

	protected $casts = [
		'quantidade' => 'int',
		'produto_id' => 'int',
		'propriedade_id' => 'int',
		'manejoplantio_id' => 'int'
	];

	protected $dates = [
		'data'
	];

	protected $fillable = [
		'quantidade',
		'produto_id',
		'data',
		'slug',
		'propriedade_id',
		'manejoplantio_id'
	];

	public function manejoplantio(){
		return $this->belongsTo(\App\Models\ManejoPlantio::class);
	}

	public function produto(){
		return $this->belongsTo(\App\Models\Produto::class);
	}

	public function propriedade(){
		return $this->belongsTo(\App\Models\Propriedade::class);
	}

	public function perdas(){
		return $this->hasMany(\App\Models\Perda::class);
	}

	public function vendas(){
		return $this->hasMany(\App\Models\Venda::class);
	}
}
