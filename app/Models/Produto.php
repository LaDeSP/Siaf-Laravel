<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 19 Sep 2019 08:14:15 -0400.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Balping\HashSlug\HasHashSlug;

class Produto extends Eloquent{
	protected $table="produto";
    use SoftDeletes;
    use HasHashSlug;

	protected $casts = [
		'status' => 'bool',
		'propriedade_id' => 'int',
		'unidade_id' => 'int'
	];

	protected $fillable = [
		'nome',
		'tipo',
		'status',
		'propriedade_id',
		'unidade_id'
	];

	public function propriedade(){
		return $this->belongsTo(\App\Models\Propriedade::class);
	}

	public function unidade(){
		return $this->belongsTo(\App\Models\Unidade::class);
	}

	public function estoques(){
		return $this->hasMany(\App\Models\Estoque::class);
	}

	public function plantios(){
		return $this->hasMany(\App\Models\Plantio::class);
    }
}
