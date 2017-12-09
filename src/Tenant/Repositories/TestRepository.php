<?php
/**
 * Created by PhpStorm.
 * User: zhoujun
 * Date: 2017/12/7
 * Time: 下午2:01
 */

namespace Larasaas\Tenant\Repositories;

use Larasaas\Tenant\Models\Demo;

class TestRepository extends TenantScopeRepository
{

    public function getName()
    {
        return "TEST Repository";
    }
    public function getList()
    {
       return Demo::get();
    }
}