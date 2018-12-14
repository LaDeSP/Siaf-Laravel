<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidade extends Model
{
    protected $table = "cidade";
    use SoftDeletes;
    static function cordenadas($id)
    {
        $cidades=self::all()->where('id','=',$id);
        return array_first($cidades);
    }
    
    public static function cidades($idestado)
    {
        $cidades=self::all()->where('estado_id','=',$idestado);
        return $cidades;
    }  
}
