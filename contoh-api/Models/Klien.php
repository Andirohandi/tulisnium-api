<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{

  protected $table = 'klien';

  public $timestamps = false;

  public function rumah_klien()
  {
    return $this->hasMany('\App\Models\RumahKlien');
  }

  public function terbayar()
  {
    return $this->hasMany('\App\Models\Terbayar');
  }

  public function cetak()
  {
    return $this->hasMany('\App\Models\Cetak');
  }

}
