<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

use App\Models\Post;


class PostController extends Controller
{
	
	public function getData(){
		$post	= Post::with('user','tag_','comment_')->get();
		return Response()->json($post,200);
	}
	
	public function getDataById($id){
		$post = Post::where('id',$id)->get();
		return response()->json($post);
	}
	
	public function getInsert(Request $req){
		$post	= new Post;
		$post->user_id		= $req->user_id;
		$post->title		= $req->title;
		$post->content		= $req->content;
		$post->like_post	= $req->like_post;
		$post->cover		= $req->cover;
		$post->view			= $req->view;
		$post->offset_cover	= $req->offset_cover;
		
		$success	= $post->save();
		
		if(!$success) return response()->json(['error' => 'error_saving_data']);
		return response()->json($post);
	}
	
	public function getUpdate(Request $req){
		
		$update	= Post::where('id', '=', $req->id)
			->update([
				'user_id'	=> $req->user_id,
				'title'		=> $req->title,
				'content'	=> $req->content,
				'like_post'	=> $req->like_post,
				'cover'		=> $req->cover,
				'view'		=> $req->view,
				'offset_cover'	=> $req->offset_cover
			]);
		
		$res = [
			'user_id'	=> $req->user_id,
			'title'		=> $req->title,
			'content'	=> $req->content,
			'like_post'	=> $req->like_post,
			'cover'		=> $req->cover,
			'view'		=> $req->view,
			'offset_cover'	=> $req->offset_cover
		];
		
		if(!$update) return response()->json(['error' => 'error_update_data']);
		return response()->json($res);
	}
	
	public function getDelete(Request $req){
		$delete	= Post::destroy($req->id);
		if($delete) return response()->json(true);
		return response()->json(false);
	}
}
