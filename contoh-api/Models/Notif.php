<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
  protected $table = 'notif';
  public $timestamps = false;

  public function user()
  {
    return $this->belongsTo('\App\Models\User');
  }
}
