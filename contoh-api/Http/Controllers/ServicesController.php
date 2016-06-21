<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class ServicesController extends Controller
{


	/**
	* Refresh Token
	*
	* @param {Object} req
	* @return {String}
	*/
  public function refreshToken(Request $req) {

    try {

				$token = JWTAuth::getToken();
				$newToken = JWTAuth::refresh($token);
				return response()->json(compact('newToken'));

    }

    catch (TokenInvalidException $e) {

        return response()->json('token_invalid', $e->getStatusCode());

    }
    catch (TokenExpiredException $e) {

        return response()->json('token_unrefreshable', $e->getStatusCode());

    }
    catch (JWTException $e) {

        return response()->json('token_error', $e->getStatusCode());

    }

  }

	/**
	* Get Current Time
	*
	* @param {Boolean} json
	* @return {Mixed}
	*/
  public function getTime($json = true) {
    /**
   	 * gmdate = Get Greenwitch Time
   	 * time() = linux timestamp in second
     * time()+60*60*7 it means now time * 60 * 60 = GMT +1 hour * 7 = GMT + 7
  	 */
    $time = gmdate('H:i', time()+(60*60*7));
    if($json)return response()->json($time);
    return $time;
  }


	/**
	* Get Current Date
	*
	* @param {Boolean} json
	* @return {Mixed}
	*/
  public function getTgl($json = true) {
    /**
    * The date format is following to SQL Date format
    * YYYY-MM-DD => 2016-02-13
    */
    $tgl = gmdate('Y-m-d', time()+(60*60*7));
    if($json) return response()->json($tgl);
    return $tgl;
  }


	/**
	* Get Current Date and Time
	*
	* @return {Object}
	*/
  public function getFullTime() {
    return response()->json([
      'tgl' => $this->getTgl(false),
      'time' => $this->getTime(false)
    ]);
  }
}
