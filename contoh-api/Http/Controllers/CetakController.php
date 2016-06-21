<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cetak;
use App\Models\ValidasiCetak;

class CetakController extends Controller
{



  public function get() {
    $res = Cetak::with('validasi')
                ->with('user')
                ->with('klien')
                ->get();
    return response()->json($res);
  }

  public function edit(Request $req) {
    $updated = Rumah::where('id','=',$req->id)
                  ->update([
                    'perum_id' => $req->perum_id,
                    'blok' => $req->blok,
                    'tipe' => $req->tipe,
                    'harga' => $req->harga,
                    'status' => $req->status,
                  ]);

    $res = [
      'id' => $req->id,
      'perum_id' => $req->perum_id,
      'blok' => $req->blok,
      'tipe' => $req->tipe,
      'harga' => $req->harga,
      'status' => $req->status,
    ];

    if($updated) return response()->json($res, 200, [], JSON_NUMERIC_CHECK);
  }


  public function delete(Request $req)
  {
    $deleted = Rumah::destroy($req->id);
    if($deleted) return response()->json(true);
    return response()->json(false);
  }


  public function getById($id) {
    $res = Rumah::where('id',$id)->with('perum')->first();
    return response()->json($res);
  }


  public function validasiCetak(Request $req)
  {
    $valid = new ValidasiCetak;
    $valid->no_transaksi = $req->no_transaksi;
    $valid->tgl = $req->tgl;
    $valid->time = $req->time;
    $valid->bank = $req->bank;
    if($req->izin) $valid->user_id = $req->myUser->id;
    $valid->save();
    if(!$valid->save()) return response()->json(['error' => 'error_saving_data']);

    // Update The Cetak
    $cetak = Cetak::where('id','=',$req->cetak_id)->update([ 'validasi_cetak_id' => $valid->id, ]);
    $valid->cetak_id = $req->cetak_id;
    return response()->json($valid, 200, [], JSON_NUMERIC_CHECK);
  }

  public function editValidasiCetak(Request $req)
  {

    $res = ValidasiCetak::where('id','=',$req->id);
    // If Izin is checked! set the user ID to who send the data
    if($req->izin == 'true'){
      $res->update([
              'no_transaksi' => $req->no_transaksi,
              'tgl' => $req->tgl,
              'time' => $req->time,
              'bank' => $req->bank,
              'user_id' => $req->myUser->id,
            ]);
    } else {
      // If not checked, set the user ID to null
      $res->update([
              'no_transaksi' => $req->no_transaksi,
              'tgl' => $req->tgl,
              'time' => $req->time,
              'bank' => $req->bank,
              'user_id' => null,
            ]);
    }
    if(!$res) return response()->json(['error' => 'error_saving_data']);
    return response()->json($res);
  }

  public function getValidasiCetak($id)
  {
    $res = ValidasiCetak::find($id);
    return response()->json($res);
  }

}
