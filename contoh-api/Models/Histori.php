<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Histori extends Model
{

  protected $table = 'histori';

  public $timestamps = false;

  public function user()
  {
    return $this->hasMany('\App\Models\User');
  }

}
