<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTController extends Controller
{
  public function auth(Request $req) {
    $credentials = $req->only('id','pass');
    $token = JWTAuth::attempt($credentials);

    try {
      if(!$token){
        return response()->json(['error' => 'invalid_credentials'],400);
      }
    } catch(JWTException $e) {
      return response()->json(['error' => 'could_not_created_token'],500);
    }

    return response()->json(compact('token'));

  }
}
