<?php

namespace Larasaas\Tenant;

use Illuminate\Database\Eloquent\Model as Eloqent;
use HipsterJazzbo\Landlord\BelongsToTenants;

/**
 * Larasaas\Tenant\Model
 *
 * @mixin \Eloquent
 */
class Model extends Eloqent
{
    use BelongsToTenants;

    public $tenantColumns = ['tenant_id'];

    protected static function boot()
    {
        parent::boot();
        //下面这行解决Landlord插件的在respository中无效的问题。
        static::addGlobalScope(new \Larasaas\Tenant\Scopes\TenantScope());
    }

}
