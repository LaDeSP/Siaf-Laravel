<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
class ManejoPlantio extends Pivot{
    protected $table = "manejoplantio";
    use SoftDeletes;
    
    protected $casts = [
        'ID' => 'int',
        'data_hora'=>'datetime:Y-m-d',
    ];
    
    protected $dates = [
        'data_hora'
    ];
    
    protected $fillable = [
        'Id'=>'id',
        'Descricao'=>'descricao',
        'Data_hora'=>'data_hora',
        'Horas_utilizadas'=>'horas_utilizadas',
        'Plantio_id'=>'plantio_id',
        'Manejo_id'=>'manejo_id'
    ];
    
    public function manejo(){
        return $this->belongsTo(\App\Models\Manejo::class);
    }

    public function plantio(){
        return $this->belongsTo(\App\Models\Plantio::class);
    }
}
