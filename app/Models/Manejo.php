<?php

/**
* Created by Reliese Model.
* Date: Tue, 27 Aug 2019 17:30:32 -0400.
*/

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Manejo extends Eloquent{
    
    protected $table = 'manejo';
    use SoftDeletes;
    
    protected $fillable = [
        'nome',
        'slug'
    ];
    
    public function plantios(){
        return $this->belongsToMany(\App\Models\Plantio::class, 'manejoplantio')->using('App\Models\ManejoPlantio')
        ->withPivot('id', 'descricao', 'data_hora', 'horas_utilizadas');
    }
}
