<?php
/**
 * Created by PhpStorm.
 * User: zhoujun
 * Date: 2017/12/7
 * Time: 下午1:59
 */

namespace Larasaas\Tenant\Models;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Larasaas\Tenant\Model;
use Spatie\Permission\Traits\HasRoles;

/**
 * Larasaas\Tenant\Models\Demo
 *
 * @property int $id
 * @property int $tenant_id
 * @property string $petname
 * @property string $pettype
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Demo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Demo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Demo wherePetname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Demo wherePettype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Demo whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Demo whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Demo permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Demo role($roles)
 */
class Demo extends ModeL
{
    use HasRoles;
    protected $guard_name = 'jwt'; // or whatever guard you want to use
    protected $table='Pets';
}