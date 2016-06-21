<?php

namespace App\Http\Middleware;

use Closure;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use App\Models\User;

class JWTCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        try {
            $user = JWTAuth::parseToken()->toUser();

            if (! $user  ) {
                return response()->json('token_not_found', 404);
            }
            $request['myUser'] = $user;

        }
        catch (TokenInvalidException $e) {

            return response()->json('token_invalid', $e->getStatusCode());

        }
        catch (TokenExpiredException $e) {

            return redirect('/API/TOKEN/REFRESH');

        }
        catch (JWTException $e) {

            return response()->json('token_error', $e->getStatusCode());

        }
        return $next($request);
    }
}
