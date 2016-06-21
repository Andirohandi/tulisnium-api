<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model{
	
	protected $table = "tag"; 
	public $timestamps = false;
	
	public function post_(){
		return $this->belongsTo('\App\Models\Post');
	}
}
