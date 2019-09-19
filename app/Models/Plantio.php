<?php

/**
* Created by Reliese Model.
* Date: Tue, 27 Aug 2019 17:22:16 -0400.
*/

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Balping\HashSlug\HasHashSlug;

class Plantio extends Eloquent{
    use SoftDeletes;
    use HasHashSlug;
    protected $table = 'plantio';
    
    protected $casts = [
        'quantidade_pantas' => 'int',
        'talhao_id' => 'int',
        'produto_id' => 'int'
    ];
    
    protected $dates = [
        'data_semeadura',
        'data_plantio'
    ];
    
    protected $fillable = [
        'id',
        'data_semeadura',
        'data_plantio',
        'quantidade_pantas',
        'talhao_id',
        'slug',
        'produto_id'
    ];
    
    public function produto(){
        return $this->belongsTo(\App\Models\Produto::class);
    }
    
    public function talhao(){
        return $this->belongsTo(\App\Models\Talhao::class);
    }
    
    public function manejos(){
        return $this->belongsToMany(\App\Models\Manejo::class, 'manejoplantio')->using('App\Models\ManejoPlantio')->withPivot('id', 'descricao', 'data_hora', 'horas_utilizadas');
    }
    
    public static function get($id=null){
        if ($id == null){
            $plantio = self::all();
            return $plantio;
        }
        $plantio = self::find($id);
        return [$plantio, 200];
    }
}
