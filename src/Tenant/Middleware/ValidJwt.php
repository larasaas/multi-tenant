<?php

namespace Larasaas\Tenant\Middleware;

use Closure;
use HipsterJazzbo\Landlord\Facades\Landlord;
use Illuminate\Support\Facades\Auth;

class ValidJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $tokenType = 'api_token', $guard = 'jwt')
    {

        if ($request->ajax() || $request->wantsJson()) {
            if (($errors = Auth::guard($guard)->validateToken($tokenType)) === true ) {
                if (Auth::guard($guard)->tokenIsApi()) {
                    if (Auth::guard($guard)->guest()) {
                        return response()->json('Unauthorized.', 401);
                    }

                    $tenant_id=Auth::guard($guard)->preload()->data->t_i;
                    Landlord::addTenant("tenant_id",$tenant_id);
                }

            } else {
                return response()->json(['error' => $errors['message']], $errors['code']);
            }
        } else {
            //return response()->json(['error' =>'Request must accept a json response.'], 422);
            $secret_key=config('jwt.secret_key');
           if(! $request->api_token){
               return response()->json('Unauthorized.', 401);
           }
           $api_token=$request->api_token;
           $jwt= new CommonJWT(
               $api_token,
               $secret_key
           );

           $data=$jwt->get();
           if(empty($data)){
               return response()->json('Unauthorized.', 401);
           }

           $tenant_id=$data->t_i;
           Landlord::addTenant("tenant_id",$tenant_id);
        }

        return $next($request);
//
//        if ($request->ajax() || $request->wantsJson()) {
//            if (($errors = Auth::guard($guard)->validateToken($tokenType)) === true ) {
//                if (Auth::guard($guard)->tokenIsApi()) {
//                    if (Auth::guard($guard)->guest()) {
//                        return response()->json('Unauthorized.', 401);
//                    }
//
//                    $secret_key=config('jwt.secret_key');
//
//                    if($request->api_token){
//                        $api_token=$request->api_token;
//                    }else{
//                        $api_token=$request->header('authorization');
//                        $api_token= substr($api_token,7);
//                    }
//
//                    $jwt= new CommonJWT(
//                        $api_token,
//                        $secret_key
//                    );
//
//                    $data=$jwt->get();
//                    if(empty($data)){
//                        return response()->json('Unauthorized.', 401);
//                    }
//
//
//                    $tenant_id=$data->t_i;
//                    Landlord::addTenant("tenant_id",$tenant_id);
//
//                }
//            } else {
//                return response()->json(['error' => $errors['message']], $errors['code']);
//            }
//        } else {
//            return response()->json(['error' =>'Request must accept a json response.'], 422);
//        }
//
//
//        return $next($request);


    }
}
