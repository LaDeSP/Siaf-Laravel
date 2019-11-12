<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 14 Aug 2019 17:00:52 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Propriedade extends Eloquent{
	use SoftDeletes;
	protected $table = 'propriedade';

	protected $casts = [
		'users_id' => 'int',
		'cidade_id' => 'int'
	];

	protected $fillable = [
		'users_id',
		'nome',
		'localizacao',
		'cidade_id',
		'slug'
	];

	public function cidade(){
		return $this->belongsTo(\App\Models\Cidade::class);
	}

	public function user(){
		return $this->belongsTo(\App\Models\User::class, 'users_id');
	}

	public function despesas(){
		return $this->hasMany(\App\Models\Despesa::class);
	}

	public function estoques(){
		return $this->hasMany(\App\Models\Estoque::class, 'propriedade_id');
	}

	public function investimentos(){
		return $this->hasMany(\App\Models\Investimento::class);
	}

	public function produtos(){
		return $this->hasMany(\App\Models\Produto::class);
	}

	public function talhoes(){
		return $this->hasMany(\App\Models\Talhao::class);
    }
}
