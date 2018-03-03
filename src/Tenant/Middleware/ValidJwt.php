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
                        response()->json([
                            'code'=>401,
                            'message' => '未登录，请求的资源不允许访问',
                            'errors'=>[],
                        ], 200);
                    }else{
//                        print_r(Auth::guard($guard)->user());die();
//                        登录验证后开始做租户限制
                        $user=Auth::guard('jwt')->user();
//                        在之前验证登录租户(员工/顾客/超级管理员)
                        $tenant_id=$user->tenant_id;
                        //设置租户
                        Landlord::addTenant("tenant_id",$tenant_id);

//                        $tenant = Tenant::findOrFail($tenant_id);
//                        Landlord::addTenant($tenant);

                        return $next($request);
//                        return $next(request());
                    }
                }else{

                    return response()->json([
                        'code'=>401,
                        'message' => 'token is not api',
                        'errors'=>[],
                    ], 200);
                }
            } else {
                return response()->json([
                    'code'=>401,
                    'message' => $errors['message'],
                    'errors'=>[],
                ], 200);
            }
        }else {
//            return response()->json(['code'=>422,'message' =>'Request must accept a json response.','errors'=>[]],200);
//            基于安全考虑不显示。
            die('No way');



        }


    }
}
