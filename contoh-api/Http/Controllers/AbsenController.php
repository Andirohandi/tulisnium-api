<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Absen;

class AbsenController extends Controller
{
  public function absen(Request $req) {
    $absen = new Absen;
    $absen->user_id = $req->myUser->id;
    $absen->time = $req->time;
    $absen->tgl = $req->tgl;
    $absen->status = $req->status;
    if($absen->save()) return response()->json($absen);
    return response()->json(['error' => 'error_saving_data']);
  }

  public function absenHariIni(Request $req) {
    $absen = Absen::where([
      ['user_id',$req->myUser->id],
      ['status',$req->status],
      ['tgl',$req->tgl],
    ])->first();
    if($absen) return response()->json($absen);
    return response()->json(false);
  }

}
