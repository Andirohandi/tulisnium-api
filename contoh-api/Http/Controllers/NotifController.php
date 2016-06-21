<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Notif;
use App\Models\Notifier;

class NotifController extends Controller
{

  public function addNotifier(Request $req) {
    $notifier = new Notifier;
    $notifier->user_id = $req->user_id;
    $notifier->tgl = $req->tgl;
    if($notifier->save()) return response()->json($notifier);
    return response()->json(['error' => 'error_saving_data']);
  }

  public function deleteNotifier(Request $req) {
    $deleted = Notifier::destroy($req->id);
    if($deleted) return response()->json(true);
    return response()->json($req->id);
  }

  public function addNotif(Request $req) {
    $notif = new Notif;
    $notif->user_id = $req->user_id;
    $notif->headline = $req->headline;
    $notif->detil = $req->detil;
    $notif->thumbnail = $req->thumbnail;
    $notif->action = $req->action;
    $notif->tgl = $req->tgl;
    $notif->status = $req->status;
    if(!$notif->save()) return response()->json(['error' => 'error_saving_data']);

    $findFirst = Notifier::where('user_id',$req->user_id);
    if($findFirst->count() === 0){
      $notifier = new Notifier;
      $notifier->user_id = $req->user_id;
      $notifier->tgl = $req->tgl;
      if(!$notifier->save()) return response()->json(['error' => 'error_saving_data']);
    } else {
      $updated = $findFirst->update([ 'tgl' => $req->tgl ]);
      if(!$updated) return response()->json(['error' => 'error_update_notifier']);
    }

    return response()->json($notif);
  }

  public function polling(Request $req) {
    $res = Notifier::where('user_id',$req->myUser->id)->first();
    if($res) return response()->json($res);
    return response()->json(false);
  }

  public function get(Request $req) {
    $res = Notif::where('user_id',$req->myUser->id)
                ->orderBy('id','desc');
    if($req->limit) $res->limit($req->limit);
    $res = $res->get();
    return response()->json($res);
  }

  public function getFromPolling(Request $req) {
    // JS array to PHP via AJAX
    // in JS need to JSON.stringify it first
    // while in PHP it need json_decode
    // refs: https://www.sitepoint.com/community/t/passing-array-data-from-javascript-to-php/37029/3
    $res = Notif::where('user_id', $req->myUser->id)
                ->whereBetween('tgl', [$req->tgl_awal, $req->tgl_sekarang])
                ->whereNotIn('id',json_decode($req->notIn))
                ->get();
    return response()->json($res);
  }

  public function read(Request $req) {
    $updated = Notif::where('id',$req->id)
                    ->update([ 'status' => 'read' ]);
    if($updated) return response()->json(true);
    return response()->json(false);
  }

}
