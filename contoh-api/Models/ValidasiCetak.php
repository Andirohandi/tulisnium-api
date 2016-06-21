<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidasiCetak extends Model
{

  protected $table = 'validasi_cetak';

  public $timestamps = false;

  public function cetak()
  {
    return $this->hasMany('\App\Models\Cetak');
  }

  public function user()
  {
    return $this->belongsTo('\App\Models\User');
  }

}
