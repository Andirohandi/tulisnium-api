<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\User;

class UserController extends Controller
{

  public function login(Request $req) {

    $username = $req['username'];
    $pass = $req['pass'];
    $user = User::where([
      ['username',$username],
      ['pass',$pass]
    ])->first();

    if(!$user) return response()->json(['error' => 'user_not_found']);

    $token = JWTAuth::fromUser($user);
    // $credentials = $req->only('username','pass');
    // $token = JWTAuth::attempt($credentials);

    try {
      if(!$token){
        return response()->json(['error' => 'invalid_credentials'],400);
      }
    } catch(JWTException $e) {
      return response()->json(['error' => 'could_not_created_token','e' => $e],500);
    }

    return response()->json([
      'username' => $user['username'],
      'token' => $token,
      'nama' => $user['nama'],
      'foto' => $user['foto'],
      'biro' => $user['biro']
    ]);

  }

  public function logged(Request $req)
  {
		$token = JWTAuth::getToken();
    return response()->json([
      'username' => $req->myUser->id,
      'username' => $req->myUser->username,
      'token' => $token,
      'nama' => $req->myUser->nama,
      'foto' => $req->myUser->foto,
      'biro' => $req->myUser->biro
    ]);
  }


  public function getOneByBiro($biro)
  {
    $res = User::where('biro',$biro)->first();
    if($res) return response()->json($res);
  }

}
