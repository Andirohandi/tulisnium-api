<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifier extends Model{
	
	protected $table = "notifier";
	protected $primaryKey = "user_id";
	public $timestamps = false;

	public function user_(){
		return $this->belongsTo('\App\Models\User');
	}
	
}
