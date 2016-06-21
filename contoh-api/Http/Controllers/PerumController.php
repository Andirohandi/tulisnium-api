<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Perum;

class PerumController extends Controller
{

  public function perumAll() {
    $perums = Perum::all();
    return response()->json($perums);
  }

  public function newPerum(Request $req)
  {
    $perum = new Perum;
    $perum->nama = $req->nama;
    $perum->desa = $req->desa;
    $perum->kecamatan = $req->kecamatan;
    $perum->kota = $req->kota;
    $perum->singkatan = $req->singkatan;
    $perum->save();
    if(!$perum->save()) return response()->json(['error' => 'error_saving_data']);
    return response()->json($perum);
  }

  public function edit(Request $req) {
    $updated = Perum::where('id','=',$req->id)
                  ->update([
                    'nama' => $req->nama,
                    'desa' => $req->desa,
                    'kecamatan' => $req->kecamatan,
                    'kota' => $req->kota,
                    'singkatan' => $req->singkatan,
                  ]);

    $res = [
      'id' => $req->id,
      'nama' => $req->nama,
      'desa' => $req->desa,
      'kecamatan' => $req->kecamatan,
      'kota' => $req->kota,
      'singkatan' => $req->singkatan,
    ];

    if($updated) return response()->json($res);
  }


  public function delete(Request $req)
  {
    $deleted = Perum::destroy($req->id);
    if($deleted) return response()->json(true);
    return response()->json(false);
  }

}
