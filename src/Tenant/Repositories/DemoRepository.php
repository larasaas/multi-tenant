<?php
/**
 * Created by PhpStorm.
 * User: zhoujun
 * Date: 2017/12/7
 * Time: 下午2:01
 */

namespace Larasaas\Tenant\Repositories;

use Larasaas\Tenant\Models\Demo;

class DemoRepository extends TenantScopeRepository
{

    protected $demo;
    //这里不可以通过__construct()方法的参数传递, 因为在中间件中根据用户登录情况使用scope，提前实例化会导致不受租户ID限制，
    //这里通过父级类中的构造函数设置scope，然后在实例化具体的entity，或者不使用构造函数，然后直接用Facades访问entity。
    public function __construct()
    {
        parent::__construct();
        $this->demo=app(Demo::class);
    }

    public function getName()
    {
        return "DEMO Repository";
    }
    public function getList()
    {

        return $this->demo->get();
    }
}