<?php
/**
 * Created by PhpStorm.
 * User: zhoujun
 * Date: 2017/12/7
 * Time: 下午1:48
 */

namespace Larasaas\Tenant\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Larasaas\Services\DemoService;
use Larasaas\Services\OrderService;
use Larasaas\Tenant\Exceptions\UnauthorizedException;
use Larasaas\Tenant\Models\Demo;
use Larasaas\Tenant\Repositories\DemoRepository;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DemoController extends Controller
{
    protected $demoRepository;
    protected $demoService;
    protected $orderService;

    public function __construct(DemoRepository $demoRepository,DemoService $demoService,OrderService $orderService)
    {
        $this->demoRepository=$demoRepository;
        $this->demoService=$demoService;
        $this->orderService=$orderService;

//        dd(Auth::guard('jwt')->user());
//        $role = Role::create(['guard_name' => 'jwt','name' => 'writer','display_name'=>"作者"]);
//        $permission = Permission::create(['guard_name' => 'jwt','name' => 'edit articles','display_name'=>"编辑"]);


        $user=Auth::guard('jwt')->user();
//        $user=User::findOrFail(2);
//        dd($user);

        //为用户设置角色，可多个。
//        $user->assignRole('admin');//全程隔离租户处理，放心使用。
//        $roles = $user->getRoleNames();
//        dd($roles);

        //获取具备writer角色的所有用户。
//        $users = User::role('writer')->get();         //查询scope，根据角色限制查询的范围。/ Returns only users with the role 'writer'
//        dd($users);

        //获取具备edit articles权限的用户
//        $users = User::permission('publish articles')->get();
//        dd($users);

//
        //直接赋权给用户（非角色）。
//        dd($user->givePermissionTo('edit articles'));
        //同上，支持一次多个权限判断；
//        dd($user->givePermissionTo('publish articles','delete articles'));
//        dd($user->givePermissionTo(['edit articles', 'delete articles']));  //或通过数组方式。

        //从用户（非角色）身上移除权限
//        dd($user->revokePermissionTo('delete articles'));

        //同步一次性赋予用户权限（删除并添加）。
//        dd($user->syncPermissions(['edit articles', 'delete articles']));

        //判断是否具备某个权限
//        dd($user->hasPermissionTo('edit articles'));
        //同上，支持多个判断
//        dd($user->hasAnyPermission(['edit articles', 'publish articles', 'unpublish articles']));

        // 为一个用户指定一个角色，【需注意重复Key的问题】。
//        $user->assignRole('writer');
        //同上，也可以一次性为一个用户指定多个角色。
//        $user->assignRole('writer', 'admin');
        //同上，可以使用数组形式一次性为用户指定多个角色。
//        $user->assignRole(['writer', 'admin']);
        //从用户身上移除一个角色。
//        $user->removeRole('writer');

        //查询角色
        $role = Role::findByName('writer');
        //为角色赋权
//        $role->givePermissionTo('edit articles');

        //判断角色是否有某个权限
//        dd($role->hasPermissionTo('edit articles'));

        //为用户用户同步所选角色来代替当前角色(删除并添加)。
//        $user->syncRoles(['admin','writer']);

        //决定用户是否具备某个角色。
//        dd($user->hasRole('writer'));

        //判断是否为用户分配了角色
//        dd($user->hasAnyRole(Role::all()));

        //判断是否具备某个权限(直接权限或角色权限)？
//        dd($user->can('publish articles'));

        //获取直接赋予用户的权限 ,以下两种方式：
//        $permissions = $user->permissions;
//        $permissions = $user->getDirectPermissions();
        //获取用户所在角色拥有的权限；
//        $permissions = $user->getPermissionsViaRoles();
        //全部权限，继承的权限和用户权限。
//        $permissions = $user->getAllPermissions();
//        dd($permissions);

        //简单的在控制器构造函数中判断访问的权限。
        try{
            $this->middleware(['role:admin','permission:publish articles|edit articles']);
        }catch (UnauthorizedException $exception){
            dd($exception);
        }

       // dd($user->hasPermissionTo('publish articles'));
       // $this->middleware(['role:super-admin','permission:publish articles|edit articles']);

    }

    public function index()
    {
        return $this->demoRepository->getList();  //
       // return Demo::all();
    }


    public function store(Request $request)
    {
        $qty = $request->input('qty');

        $discount = $this->orderService->getDiscount($qty);
        $total = $this->orderService->getTotal($qty, $discount);

        echo($total);

        //$this->demoService->send($request->all());
    }
}