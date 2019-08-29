<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Aug 2019 09:59:54 -0400.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Cidade extends Eloquent{
	use SoftDeletes;
	protected $table = 'cidade';

	protected $casts = [
		'estado_id' => 'int',
		'latitude' => 'float',
		'longitude' => 'float'
	];

	protected $fillable = [
		'estado_id',
		'latitude',
		'longitude',
		'nome'
	];

	public function estado(){
		return $this->belongsTo(\App\Models\Estado::class);
	}

	public function propriedades(){
		return $this->hasMany(\App\Models\Propriedade::class);
    }
    
    static function cordenadas($id){
        $cidades=self::all()->where('id','=',$id);
        return array_first($cidades);
    }
    
    public static function cidades($idestado){
        $cidades=self::all()->where('estado_id','=',$idestado);
        return $cidades;
    }
}
