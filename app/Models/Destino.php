<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 28 Aug 2019 17:23:45 -0400.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Destino
 * 
 * @property int $id
 * @property string $nome
 * @property int $tipo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $perdas
 * @property \Illuminate\Database\Eloquent\Collection $vendas
 *
 * @package App\Models
 */
class Destino extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'destino';

	protected $casts = [
		'tipo' => 'int'
	];

	protected $fillable = [
		'nome',
		'tipo'
	];

	public function perdas()
	{
		return $this->hasMany(\App\Models\Perda::class);
	}

	public function vendas()
	{
		return $this->hasMany(\App\Models\Venda::class);
	}
}
