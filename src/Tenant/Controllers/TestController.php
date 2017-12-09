<?php
/**
 * Created by PhpStorm.
 * User: zhoujun
 * Date: 2017/12/7
 * Time: 下午1:48
 */

namespace Larasaas\Tenant\Controllers;

use Illuminate\Http\Request;
use Larasaas\Tenant\Models\Demo;
use Larasaas\Tenant\Repositories\TestRepository;


class TestController extends Controller
{
    protected $testRepository;

    public function __construct(TestRepository $testRepository)
    {
        $this->testRepository=$testRepository;

    }

    public function index()
    {
       // return $this->testRepository->getList();
        return Demo::all();
    }


}