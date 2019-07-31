<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    protected $table = "estado";
    use SoftDeletes;
  static function estados()
      {
          $estados=self::all();
          return $estados;
      }
}
