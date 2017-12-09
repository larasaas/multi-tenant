<?php

namespace Larasaas\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Larasaas\Tenant\Models\Tenant
 *
 * @property int $id
 * @property string $company 租户公司名称
 * @property int $type 租户类型
 * @property string $expire_date 到期时间
 * @property int $is_active 状态
 * @property string|null $contact 联系人
 * @property string|null $phone 联系电话
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Tenant whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Tenant whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Tenant whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Tenant whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Tenant wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Tenant whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Larasaas\Tenant\Models\Tenant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tenant extends Model
{
    
}
