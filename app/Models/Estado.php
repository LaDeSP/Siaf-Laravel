<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = "estado";

  static function estados()
      {
          $estados=self::all();
          return $estados;
      }
}
