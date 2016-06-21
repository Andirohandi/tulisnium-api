<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perum extends Model
{
  protected $table = 'perum';
  public $timestamps = false;

  public function rumah()
  {
    return $this->hasMany('\App\Models\Rumah');
  }
}
