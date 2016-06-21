<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model{
	
	protected $table = "post"; 
	public $timestamps = false;
	
	public function user(){
		return $this->belongsTo('\App\Models\User');
	}
	
	public function tag_(){
		return $this->hasMany('\App\Models\Tag');
	}
	
	public function comment_(){
		return $this->hasMany('\App\Models\Comment');
	}
}
