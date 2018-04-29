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

    protected static $tenantColumns= ['tenant_id'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \Larasaas\Tenant\Scopes\TenantScope(static::$tenantColumns));
    }





}
