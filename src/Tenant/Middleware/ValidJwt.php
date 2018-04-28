<?php

namespace Larasaas\Tenant\Middleware;

use Closure;
use HipsterJazzbo\Landlord\Facades\Landlord;
use Illuminate\Support\Facades\Auth;
use Paulvl\JWTGuard\JWT\Token\CommonJWT;

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

        $secret_key=config('jwt.secret_key');

        if($request->api_token){
            $api_token=$request->api_token;
        }else{
            $api_token=$request->header('authorization');
            $api_token= substr($api_token,7);
        }

        $jwt= new CommonJWT(
            $api_token,
            $secret_key
        );

        $data=$jwt->get();
        if(empty($data)){
            // return response()->json(['error' => 'Unauthorized'], '401');
            return response()->json('Unauthorized.', 401);
        }

        //测试是否验证登录
//        $user=Auth::user();
//        print_r(Auth::user());die();
        
//        $user_id=$data->user_id;


        $tenant_id=$data->tenant_id;
        Landlord::addTenant("tenant_id",$tenant_id);



        return $next($request);

//==========
////        if ($request->ajax() || $request->wantsJson()) {
//            if (($errors = Auth::guard($guard)->validateToken($tokenType)) === true ) {
//
//                    if (Auth::guard($guard)->guest()) {
//                        return response()->json('Unauthorized.', 401);
//                    }else{
//                        //登录验证后开始做租户限制
//                        $user=Auth::guard('jwt')->user();
//                        //在之前验证登录租户(员工/顾客/超级管理员)
//                        $tenant_id=$user->tenant_id;
//                        //设置租户
//                        Landlord::addTenant("tenant_id",$tenant_id);
////                        $tenant = Tenant::findOrFail($tenant_id);
////                        Landlord::addTenant($tenant);
//                    }
//
////
////                }
//
//            } else {
//                return response()->json(['error' => $errors['message']], $errors['code']);
//            }
////        } else {
////            return response()->json(['error' =>'Request must accept a json response.'], 422);
////        }

//        return $next($request);
    }
}
