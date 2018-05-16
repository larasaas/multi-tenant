<?Php

namespace Larasaas\Tenant\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    private $tenantColumn;
    public function __construct($tenantColumns)
    {
        $this->tenantColumn=$tenantColumns[0];
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
//        $tenantColumn=$model->getTenantColumns()[0];
        $tenantColumn=$this->tenantColumn;
       if( Auth::guard('jwt')->guest()){
           return $builder->where($tenantColumn, 0);
       }

        return $builder->where($tenantColumn, Auth::guard('jwt')->user()->tenant_id);

    }
}
