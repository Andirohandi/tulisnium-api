<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
	
	protected $table = "comment"; 
	public $timestamps = false;
	
	public function user_(){
		return $this->belongsTo('\App\Models\User');
	}
	
	public function post_(){
		return $this->belongsTo('\App\Models\Post');
	}

}
