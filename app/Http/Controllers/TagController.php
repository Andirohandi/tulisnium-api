<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

use App\Models\Tag;


class TagController extends Controller
{
	
	public function getData(){
		$tag	= Tag::all();
		return Response()->json($tag,200);
	}
	
	public function getDataById($id){
		$tag = Tag::where('id',$id)->get();
		return response()->json($tag);
	}
	
	public function getInsert(Request $req){
		$tag	= new Tag;
		$tag->post_id	= $req->post_id;
		$tag->name		= $req->name;
		
		$success	= $tag->save();
		
		if(!$success) return response()->json(['error' => 'error_saving_data']);
		return response()->json($tag);
	}
	
	public function getUpdate(Request $req){
		
		$update	= Tag::where('id', '=', $req->id)
			->update([
				'post_id'	=> $req->post_id,
				'name'		=> $req->name
			]);
		
		$res = [
			'post_id'	=> $req->post_id,
			'name'		=> $req->name
		];
		
		if(!$update){
			return response()->json(['error' => 'error_update_data']);
		} else {
			return response()->json($res);
		}
	}
	
	public function getDelete(Request $req){
		$delete	= Tag::destroy($req->id);
		if($delete) return response()->json(true);
		return response()->json(false);
	}
}
