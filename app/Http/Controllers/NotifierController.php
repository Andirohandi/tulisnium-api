<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

use App\Models\Notifier;


class NotifierController extends Controller
{
	
	public function getData(){
		$notifier	= Notifier::with('user_')->get();
		return Response()->json($notifier,200);
	}
	
	public function getDataById($id){
		$notifier = Notifier::where('user_id',$id)->get();
		return response()->json($notifier);
	}
	
	public function getInsert(Request $req){
		$notifier	= new Notifier;
		$notifier->user_id		= $req->user_id;
		
		$success	= $notifier->save();
		
		if(!$success) return response()->json(['error' => 'error_saving_data']);
		return response()->json($notifier);
	}
	
	public function getDelete(Request $req){
		$delete	= Notifier::destroy($req->user_id);
		if($delete) return response()->json(true);
		return response()->json(false);
	}
}
