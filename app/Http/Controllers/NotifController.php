<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

use App\Models\Notif;


class NotifController extends Controller
{
	
	public function getData(){
		$notif	= Notif::with('user_')->get();
		return Response()->json($notif,200);
	}
	
	public function getDataById($id){
		$notif = Notif::where('id',$id)->get();
		return response()->json($notif);
	}
	
	public function getInsert(Request $req){
		$notif	= new Notif;
		$notif->user_id		= $req->user_id;
		$notif->headline	= $req->headline;
		$notif->thumbnail	= $req->thumbnail;
		$notif->detail		= $req->detail;
		$notif->read_notif	= $req->read_notif;
		$notif->action		= $req->action;
		
		$success	= $notif->save();
		
		if(!$success) return response()->json(['error' => 'error_saving_data']);
		return response()->json($notif);
	}
	
	public function getUpdate(Request $req){
		
		$update	= Notif::where('id', '=', $req->id)
			->update([
				'user_id'		=> $req->user_id,
				'headline'		=> $req->headline,
				'thumbnail'		=> $req->thumbnail,
				'detail'		=> $req->detail,
				'read_notif'	=> $req->read_notif,
				'action'		=> $req->action
			]);
		
		$res = [
			'user_id'		=> $req->user_id,
			'headline'		=> $req->headline,
			'thumbnail'		=> $req->thumbnail,
			'detail'		=> $req->detail,
			'read_notif'	=> $req->read_notif,
			'action'		=> $req->action
		];
		
		if(!$update) return response()->json(['error' => 'error_update_data']);
		return response()->json($res);
	}
	
	public function getDelete(Request $req){
		$delete	= Notif::destroy($req->id);
		if($delete) return response()->json(true);
		return response()->json(false);
	}
}
