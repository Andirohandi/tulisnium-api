<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RumahKlien extends Model
{
  protected $table = 'rumah_klien';
  public $timestamps = false;

  public function rumah()
  {
    return $this->belongsTo('App\Models\Rumah');
  }
  public function klien()
  {
    return $this->belongsTo('App\Models\Klien');
  }
  public function terbayar()
  {
    return $this->hasMany('App\Models\Terbayar');
  }
}
