<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 *  @property int $id
 *  @property int $policy_agree
 *  @property bool $is_active
 *  @property bool $is_admin
 *  @property string $uuid
 *  @property string $name
 *  @property string $surname
 *  @property string $patronymic
 *  @property string $email
 *  @property string $password
 *  @property string $ip_address
 *  @property string $phone
 */

class User extends Authenticatable implements JWTSubject
{

    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'name',
        'surname',
        'patronymic',
        'ip_address',
        'email',
        'policy_agree',
        'password',
        'is_active',
        'is_admin',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_admin'   => 'boolean',
        'is_active'  => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i:s',
        'updated_at' => 'datetime:d.m.Y H:i:s',
    ];

    protected $appends = ['full_name'];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->surname} {$this->name}" . ($this->patronymic ? " {$this->patronymic}" : "");
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

}
