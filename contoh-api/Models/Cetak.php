<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cetak extends Model
{

  protected $table = 'cetak';

  public $timestamps = false;

  public function validasi()
  {
    return $this->belongsTo('\App\Models\ValidasiCetak');
  }

  public function klien()
  {
    return $this->belongsTo('\App\Models\Klien');
  }

  public function user()
  {
    return $this->belongsTo('\App\Models\User');
  }

}
