<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

use App\Models\User;


class UserController extends Controller
{
	
	public function getData(){
		$user	= User::all();
		return Response()->json($user,200);
	}
	
	public function getDataById($id){
		$user = User::where('id',$id)->get();
		return response()->json($user);
	}
	
	public function getInsert(Request $req){
		$user	= new User;
		$user->username	= $req->username;
		$user->pass		= $req->pass;
		$user->name		= $req->name;
		$user->bio		= $req->bio;
		$user->avatar	= $req->avatar;
		$user->web		= $req->web;
		$user->like_user= $req->like_user;
		
		$success	= $user->save();
		
		if(!$success) return response()->json(['error' => 'error_saving_data']);
		return response()->json($user);
	}
	
	public function getUpdate(Request $req){
		
		$update	= User::where('id', '=', $req->id)
			->update([
				'pass'	=> $req->pass,
				'name'	=> $req->name,
				'bio'	=> $req->bio,
				'avatar'	=> $req->avatar,
				'web'		=> $req->web,
				'like_user'	=> $req->like_user
			]);
		
		$res = [
			'pass'	=> $req->pass,
			'name'	=> $req->name,
			'bio'	=> $req->bio,
			'avatar'	=> $req->avatar,
			'web'		=> $req->web,
			'like_user'	=> $req->like_user
		];
		
		if(!$update) return response()->json(['error' => 'error_update_data']);
		return response()->json($res);
	}
	
	public function getDelete(Request $req){
		$delete	= User::destroy($req->id);
		if($delete) return response()->json(true);
		return response()->json(false);
	}
}
