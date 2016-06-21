<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terbayar extends Model
{

  protected $table = 'terbayar';

  public $timestamps = false;


  public function user()
  {
    return $this->belongsTo('\App\Models\User');
  }

  public function klien()
  {
    return $this->belongsTo('\App\Models\Klien');
  }

}
