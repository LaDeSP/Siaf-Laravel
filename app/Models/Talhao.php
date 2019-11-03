<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 14 Aug 2019 17:18:51 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Balping\HashSlug\HasHashSlug;

class Talhao extends Eloquent{
    use SoftDeletes;
    use HasHashSlug;
    protected $table='talhao';

	protected $casts = [
		'area' => 'int',
		'propriedade_id' => 'int'
	];

	protected $fillable = [
		'area',
		'nome',
        'propriedade_id',
	];

	public function propriedade(){
		return $this->belongsTo(\App\Models\Propriedade::class);
	}

	public function plantios(){
		return $this->hasMany(\App\Models\Plantio::class);
    }
}
