<?php
namespace Larasaas\Services;

use HipsterJazzbo\Landlord\Facades\Landlord;
use Illuminate\Http\Request;
use Larasaas\Tenant\Models\Tenant;

/**
 * Created by PhpStorm.
 * User: zhoujun
 * Date: 2017/12/7
 * Time: 下午1:49
 */

class VaildUserService
{
    public function setTenant(Request $request)
    {
        //验证Request


        $tenant_id=1;
        $tenant = Tenant::findOrFail($tenant_id);
        //设置租户
        Landlord::addTenant($tenant);
    }

    //获取登录用户的ID
    public function vaildUser()
    {

    }
}