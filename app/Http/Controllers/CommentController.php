<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

use App\Models\Comment;


class CommentController extends Controller
{
	
	public function getData(){
		$comment	= Comment::with('user_')->get();
		return Response()->json($comment,200);
	}
	
	public function getDataById($id){
		$comment = Comment::where('id',$id)->get();
		return response()->json($comment);
	}
	
	public function getInsert(Request $req){
		$comment	= new Comment;
		$comment->user_id		= $req->user_id;
		$comment->post_id		= $req->post_id;
		$comment->content		= $req->content;
		
		$success	= $comment->save();
		
		if(!$success) return response()->json(['error' => 'error_saving_data']);
		return response()->json($comment);
	}
	
	public function getUpdate(Request $req){
		
		$update	= Comment::where('id', '=', $req->id)
			->update([
				'user_id'	=> $req->user_id,
				'post_id'	=> $req->post_id,
				'content'	=> $req->content,
			]);
		
		$res = [
			'user_id'	=> $req->user_id,
			'post_id'	=> $req->post_id,
			'content'	=> $req->content,
		];
		
		if(!$update) return response()->json(['error' => 'error_update_data']);
		return response()->json($res);
	}
	
	public function getDelete(Request $req){
		$delete	= Comment::destroy($req->id);
		if($delete) return response()->json(true);
		return response()->json(false);
	}
}
