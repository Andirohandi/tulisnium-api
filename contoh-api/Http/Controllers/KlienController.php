<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Klien;

class KlienController extends Controller
{
    public function newKlien(Request $req)
    {
      $klien = new Klien;
      $klien->no_ktp = $req->no_ktp;
      $klien->nama = $req->nama;
      $klien->alamat_ktp = $req->alamat_ktp;
      $klien->alamat_sekarang = $req->alamat_sekarang;
      $klien->no_telp = $req->no_telp;
      $klien->nama_kantor = $req->nama_kantor;
      $klien->alamat_kantor = $req->alamat_kantor;
      $klien->no_telp_kantor = $req->no_telp_kantor;
      $klien->no_fax = $req->no_fax;
      $klien->jabatan = $req->jabatan;
      $klien->tgl_daftar = $req->tgl_daftar;
      if(!$klien->save()) return response()->json(['error' => 'error_saving_data']);

      $rumah = new \App\Models\RumahKlien;
      $rumah->rumah_id = $req->rumah_id;
      $rumah->klien_id = $klien->id;
      $rumah->tgl = $req->tgl;
      $rumah->harga = $req->harga;
      $rumah->um = $req->um;
      $rumah->kpr = $req->kpr;
      $rumah->ppn = $req->ppn;
      $rumah->pph = $req->pph;
      $rumah->bphtb = $req->bphtb;
      $rumah->biaya_admin = $req->biaya_admin;
      $rumah->notaris = $req->notaris;
      $rumah->pln = $req->pln;
      $rumah->air = $req->air;
      $rumah->diskon = $req->diskon;
      $rumah->total = $req->total;
      $rumah->cara_bayar = $req->cara_bayar;
      $rumah->ket = $req->ket;
      $rumah->status = $req->status;
      $rumah->save();
      if(!$rumah->save()) return response()->json(['error' => 'error_saving_data']);

      return response()->json([
        'klien' => $klien,
        'rumah' => $rumah
      ]);

    }


    public function editKlien(Request $req) {
      $updated = Klien::where('id','=',$req->id)
                    ->update([
                      "nama" => $req->nama,
                      "alamat_ktp" => $req->alamat_ktp,
                      "alamat_sekarang" => $req->alamat_sekarang,
                      "no_telp" => $req->no_telp,
                      "nama_kantor" => $req->nama_kantor,
                      "alamat_kantor" => $req->alamat_kantor,
                      "no_telp_kantor" => $req->no_telp_kantor,
                      "no_fax" => $req->no_fax,
                      "jabatan" => $req->jabatan,
                    ]);
      if($updated) return response()->json(true);
    }



    public function beliRumahBaru(Request $req)
    {
      $rumah = new \App\Models\RumahKlien;
      $rumah->rumah_id = $req->rumah_id;
      $rumah->klien_id = $req->klien_id;
      $rumah->tgl = $req->tgl;
      $rumah->harga = $req->harga;
      $rumah->um = $req->um;
      $rumah->kpr = $req->kpr;
      $rumah->ppn = $req->ppn;
      $rumah->pph = $req->pph;
      $rumah->bphtb = $req->bphtb;
      $rumah->biaya_admin = $req->biaya_admin;
      $rumah->notaris = $req->notaris;
      $rumah->pln = $req->pln;
      $rumah->air = $req->air;
      $rumah->diskon = $req->diskon;
      $rumah->total = $req->total;
      $rumah->cara_bayar = $req->cara_bayar;
      $rumah->ket = $req->ket;
      $rumah->status = $req->status;
      $rumah->save();
      if(!$rumah->save()) return response()->json(['error' => 'error_saving_data']);

      return response()->json($rumah);

    }


    public function getKlien(Request $req)
    {
      $res = Klien::orderBy('id','desc')
                  ->with('terbayar')
                  ->with('rumah_klien')
                  ->get();
      return response()->json($res);
    }


    public function getKlienKPR(Request $req)
    {
      $res = Klien::whereHas('rumah_klien', function($query){
                      $query->where('cara_bayar', '=', 'kpr');
                    })
                  ->orderBy('id','desc')
                  ->with(['rumah_klien' => function($query){
                    $query->where('cara_bayar', '=', 'kpr')
                          ->with('terbayar');
                  }])
                  ->get();
      return response()->json($res);
    }


    public function getKlienById($id)
    {
      $res = Klien::orderBy('id','desc')
                  ->where('id', '=', $id)
                  ->with('terbayar')
                  ->with('rumah_klien')
                  ->first();
      return response()->json($res);
    }


    public function getKlienBayarById($tipe, $id)
    {
      $res = Klien::orderBy('id','desc')
                  ->where('id', '=', $id)
                  ->with(['terbayar' => function($query) use($tipe){
                    $query->where('tipe', '=', $tipe);
                  }])
                  ->with('rumah_klien.rumah.perum')
                  ->first();
      return response()->json($res);
    }


    public function deleteKlien(Request $req)
    {
      $deleted = Klien::destroy($req->id);
      if($deleted) return response()->json(true);
      return response()->json(compact('req'));
    }


    public function searchKlien(Request $req)
    {
      $res = Klien::where('klien.nama','like','%'.$req['nama'].'%');
      $res->with('rumah_klien.rumah.perum')
          ->with('terbayar');

      if($req['order']) $res->orderBy('id', $req['order']);
      if($req['limit']) $res->limit($req['limit']);
      $res = $res->get();

      return response()->json($res);
    }


    public function searchKlienBayar(Request $req, $tipe)
    {
      $res = Klien::where('klien.nama','like','%'.$req['nama'].'%');
      $res->with('rumah_klien.rumah.perum')
          ->with(['terbayar' => function($query) use($tipe){
            $query->where('tipe', '=', $tipe);
          }]);

      if($req['order']) $res->orderBy('id', $req['order']);
      if($req['limit']) $res->limit($req['limit']);
      $res = $res->get();

      // http://stackoverflow.com/questions/5323146/mysql-integer-field-is-returned-as-string-in-php
      // http://stackoverflow.com/questions/31527050/laravel-5-controller-sending-json-integer-as-string
      // return response()->json($res,200, [], JSON_NUMERIC_CHECK);
      return response()->json($res);
    }


    public function searchKlienMinimal(Request $req)
    {
      $res = Klien::where('klien.nama','like','%'.$req['nama'].'%');
      if($req['order']) $res->orderBy('id', $req['order']);
      if($req['limit']) $res->limit($req['limit']);
      $res = $res->get();
      return response()->json($res);
    }


    public function searchKlienSpesificMinimal($tipe, Request $req)
    {
      $res = Klien::where('klien.nama','like','%'.$req['nama'].'%');
      if($req['order']) $res->orderBy('id', $req['order']);
      $res->whereHas('rumah_klien', function($query) use($tipe) {
        $query->where('cara_bayar', '=', $tipe);
      });
      if($req['limit']) $res->limit($req['limit']);
      $res = $res->get();
      return response()->json($res);
    }


    public function getKlienHasRumah($id) {
      $res = Klien::whereHas('rumah_klien', function($query) use($id) {
                      $query->where('rumah_id', '=', $id);
                    })
                  ->get();
      return response()->json($res);
    }


    public function deleteRumahKlien(Request $req)
    {
      $deleted = \App\Models\RumahKlien::destroy($req->id);
      if($deleted) return response()->json(true);
      return response()->json($deleted);
    }


    public function editRumahKlien(Request $req) {
      $updated = \App\Models\RumahKlien::where('id','=',$req->id)
                    ->update([
                      'harga' => $req->harga,
                      'um' => $req->um,
                      'kpr' => $req->kpr,
                      'ppn' => $req->ppn,
                      'pph' => $req->pph,
                      'bphtb' => $req->bphtb,
                      'biaya_admin' => $req->biaya_admin,
                      'notaris' => $req->notaris,
                      'pln' => $req->pln,
                      'air' => $req->air,
                      'diskon' => $req->diskon,
                      'total' => $req->total,
                      'cara_bayar' => $req->cara_bayar,
                      'ket' => $req->ket,
                      'status' => $req->status
                    ]);
      if($updated) return response()->json(true);
    }


}
