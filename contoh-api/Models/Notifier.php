<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifier extends Model
{
  protected $table = 'notifier';
  public $timestamps = false;

  public function user()
  {
    return $this->belongsTo('\App\Models\User');
  }
}
