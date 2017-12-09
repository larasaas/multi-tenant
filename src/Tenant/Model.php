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
}
