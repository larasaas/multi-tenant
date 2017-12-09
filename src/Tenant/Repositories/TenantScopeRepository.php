<?php
/**
 * Created by PhpStorm.
 * User: zhoujun
 * Date: 2017/12/7
 * Time: 下午2:01
 */

namespace Larasaas\Tenant\Repositories;

use HipsterJazzbo\Landlord\Facades\Landlord;
use Illuminate\Support\Facades\Auth;

class TenantScopeRepository
{
    public function __construct()
    {
        if($errors = Auth::guard('jwt')->check()){
            $user=Auth::guard('jwt')->user();
            //在之前验证登录租户(员工/顾客/超级管理员)
            $tenant_id=$user->tenant_id;
            //设置租户
            Landlord::addTenant("tenant_id",$tenant_id);
        }else{
            return response()->json(['error' => $errors['message']]);
        }

    }

}