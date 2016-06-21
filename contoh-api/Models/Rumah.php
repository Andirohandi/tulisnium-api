<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
  protected $table = 'rumah';
  public $timestamps = false;

  public function perum()
  {
    return $this->belongsTo('\App\Models\Perum');
  }

  public function rumah_klien()
  {
    return $this->hasMany('App\Models\RumahKlien');
  }

}
