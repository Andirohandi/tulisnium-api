<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{
	
	protected $table = "user"; 
	public $timestamps = false;
	
	
	public function post_(){
		return $this->hasMany('\App\Models\Post');
	}
	
	public function comment_(){
		return $this->hasMany('\App\Models\Comment');
	}
	
	public function notifier_(){
		return $this->hasOne('\App\Models\Notifier');
	}
	
	public function notif_(){
		return $this->hasMany('\App\Models\Notif');
	}
	
	
	
}
