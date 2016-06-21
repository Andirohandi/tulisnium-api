<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cetak;
use App\Models\NoSeriCetak;

class PDFController extends Controller
{


  public function get($dir, $name)
  {
    $dir = strtolower($dir);

    $file = \Storage::read('/pdf/'.$dir.'/'.$name.'.pdf');
    $mime = \Storage::getMimetype('/pdf/'.$dir.'/'.$name.'.pdf');
    return response($file)->header('Content-Type',$mime);
  }


  public function viewOnly(Request $req)
  {
    return view('cetak/viewer-only');
  }

  public function viewPrintable(Request $req)
  {
    return view('cetak/viewer-printable');
  }


  public function addToTabelCetak($tipe, $seri, $nama, $tgl, $user_id, $klien_id)
  {
    $last = NoSeriCetak::where('tipe', '=', $tipe)->first();
    $cetak = new Cetak;
    $cetak->no_seri = $last->jumlah_tercetak + 1;
    $cetak->tipe = $tipe;
    $cetak->nama = $nama;
    $cetak->tgl = $tgl;
    $cetak->user_id = $user_id;
    $cetak->klien_id = $klien_id;
    // $cetak->konten = $konten;

    $last->jumlah_tercetak = $cetak->no_seri;

    if($cetak->save() && $last->save()) return $cetak;
  }


  public function cetakBaru(Request $req, $tipe)
  {
    $last = NoSeriCetak::where('tipe', '=', $tipe)->first();
    $req->no_seri = $last->jumlah_tercetak + 1;

    $pdf = \PDF::loadView('cetak/'.$tipe, compact('req'));

    if(! isset($req->paper) ) $pdf->setPaper('a4');
    if(isset($req->paper)) $pdf->setPaper($req->paper);

    if(isset($req->orientation)){
      if(! isset($req->paper) ) $pdf->setPaper('a4', $req->orientation);
      if(isset($req->paper)) $pdf->setPaper($req->paper,$req->orientation);
    }


    $dir = \Storage::exists('pdf/'+$tipe);
    if(! $dir ) \Storage::makeDirectory('pdf/'.$tipe);

    if($pdf->save(storage_path().'/app/pdf/'.$tipe.'/'.$req->nama_pdf.'.pdf')){
      $addCetak = $this->addToTabelCetak($tipe, $req->no_seri, $req->nama_pdf, $req->tgl, $req->myUser->id, $req->klien_id);
      if($addCetak) return response()->json($addCetak);
    }
  }


  public function perjanjianPengikatanJualBeli(Request $req)
  {
    return $pdf = \PDF::loadView('cetak/perjanjian-pengikatan-jual-beli')->setPaper('a4','potrait')->stream();
  }


  public function kuitansiK2()
  {
    return $pdf = \PDF::loadView('cetak/kuitansi')->setPaper('a5','landscape')->stream();
    // if($pdf->save(storage_path().'/app/pdf/pesan-baru.pdf')) return response()->json(true);
  }

}
