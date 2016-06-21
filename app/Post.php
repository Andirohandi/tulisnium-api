<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $table = "tbl_posts"; 
    protected $primaryKey = "post_id";
	
    protected $fillable = ['created_at', 'updated_at', 'user_id', 'title', 'descripstion', 'image', 'thumbnails', 'url_post', 'status_post'
    ];
}
