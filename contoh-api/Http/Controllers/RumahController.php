<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Rumah;

class RumahController extends Controller
{


  public function newRumah(Request $req)
  {
    $rumah = new Rumah;
    $rumah->perum_id = $req->perum_id;
    $rumah->blok = $req->blok;
    $rumah->tipe = $req->tipe;
    $rumah->harga = $req->harga;
    $rumah->save();
    if(!$rumah->save()) return response()->json(['error' => 'error_saving_data']);
    return response()->json($rumah);
  }

  public function getByPerumId($id) {
    $rumahs = Rumah::where('lokasi',$id)->get();
    return response()->json($rumahs);
  }

  public function get() {
    $res = Rumah::with('perum','rumah_klien')->get();
    return response()->json($res);
  }

  public function edit(Request $req) {
    $updated = Rumah::where('id','=',$req->id)
                  ->update([
                    'perum_id' => $req->perum_id,
                    'blok' => $req->blok,
                    'tipe' => $req->tipe,
                    'harga' => $req->harga,
                  ]);

    $res = [
      'id' => $req->id,
      'perum_id' => $req->perum_id,
      'blok' => $req->blok,
      'tipe' => $req->tipe,
      'harga' => $req->harga,
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

  public function tersediaByPerumId($id, Request $req) {
    $res = Rumah::where('perum_id',$id);
    if($req['blok']) $res->where('blok','like','%'.$req['blok'].'%');

    // refs: http://www.fullstack4u.com/laravel/laravel-5-query-where-not-has/s
    $res->has('rumah_klien','=',0); // it doesn't has a relate in rumah klien table data rowss

    // Statement "OR" harus dipisah.. soalnya dia nggak bakal ambil refs dari $res pertama lagi
    // kalau nggak dipisah bakal menghasilkan :
    // rumah where perum_id = $id and has ( blabla ) or rumah whereHas(blablabl) ---> tanpa referensi ke id lagi
    // kalau di pisah maka ia berjalan sesuai keinginan
    $res->orWhere('perum_id',$id)
        ->WhereHas('rumah_klien', function($query) {
            $query->where('status', '=', 'booking'); // Or it has a relate, but the status is still booking
          });

    if($req['limit']) $res->limit($req['limit']);
    $res = $res->get();

    return response()->json($res,200, [], JSON_NUMERIC_CHECK);
    // return view('json-test',compact('res'));
  }


}
