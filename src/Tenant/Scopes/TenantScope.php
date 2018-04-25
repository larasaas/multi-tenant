<?Php

namespace Larasaas\Tenant\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $tenantColumn=$model->getTenantColumns()[0];
        if( Auth::guard('jwt')->guest()){
            return $builder->where($tenantColumn, 0);
        }

        return $builder->where($tenantColumn, Auth::guard('jwt')->user()->tenant_id);

    }
}
