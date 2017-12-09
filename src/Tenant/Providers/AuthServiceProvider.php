<?php

namespace Larasaas\Tenant\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        foreach ($this->getPermissions() as $permission) {
//            Gate::define($permission->name, function ($user) use ($permission) {
//                if ($user->isSuperAdmin() || $user->hasPermission($permission)) {
//                    return true;
//                }
//            });
//        }

    }

//    public function getPermissions()
//    {
//        try {
//            return Permission::with('roles')->get();//拿到所有的permissions和对应的roles
//        } catch (\Exception $exception) {
//            return;
//        }
//    }
}
