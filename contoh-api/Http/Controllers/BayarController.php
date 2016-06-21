<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Terbayar;

class BayarController extends Controller
{
  public function bayar(Request $req, $tipe)
  {
    $bayar = new Terbayar;
    $bayar->tgl = $req->tgl;
    $bayar->user_id = $req->myUser->id;
    $bayar->klien_id = $req->klien_id;
    $bayar->rumah_klien_id = $req->rumah_klien_id;
    $bayar->nominal = $req->nominal;
    $bayar->tipe = $tipe;
    $bayar->bank = $req->bank;

    $saved = $bayar->save();

    if(!$saved) return response()->json(['error' => 'error_saving_data']);

    return response()->json($bayar, 200, [], JSON_NUMERIC_CHECK);

  }

  public function edit(Request $req)
  {

    $updated = Terbayar::where('id','=',$req->id)
                  ->where('user_id','=',$req->myUser->id)
                  ->where('rumah_klien_id','=',$req->rumah_klien_id)
                  ->where('klien_id','=',$req->klien_id)
                  ->update([
                    'nominal' => $req->nominal,
                    'tgl' => $req->tgl,
                    'bank' => $req->bank,
                  ]);

    $res = [
      'id' => $req->id,
      'user_id' => $req->myUser->id,
      'rumah_klien_id' => $req->rumah_klien_id,
      'klien_id' => $req->klien_id,
      'nominal' => $req->nominal,
      'tgl' => $req->tgl,
      'bank' => $req->bank,
    ];

    if($updated) return response()->json($res, 200, [], JSON_NUMERIC_CHECK);

  }


  public function delete(Request $req)
  {
    $deleted = Terbayar::destroy($req->id);
    if($deleted) return response()->json(true);
  }

  public function getTerbayarByKlienIdAndRumahKlienId($klien_id, $rumah_klien_id)
  {
    $res = Terbayar::where('klien_id','=',$klien_id)
                  ->where('rumah_klien_id','=',$rumah_klien_id)
                  ->with('user')
                  ->get();
    return response()->json($res);
  }

  public function getTerbayarByKlienIdAndRumahKlienIdKPROnly($klien_id, $rumah_klien_id)
  {
    $res = Terbayar::where('klien_id','=',$klien_id)
                  ->where('rumah_klien_id','=',$rumah_klien_id)
                  ->where('tipe','=','kpr')
                  ->with('user')
                  ->get();
    return response()->json($res);
  }

  public function getTerbayarByKlienIdAndRumahKlienIdNoKPR($klien_id, $rumah_klien_id)
  {
    $res = Terbayar::where('klien_id','=',$klien_id)
                  ->where('rumah_klien_id','=',$rumah_klien_id)
                  ->where('tipe','!=','kpr')
                  ->with('user')
                  ->get();
    return response()->json($res);
  }

}
