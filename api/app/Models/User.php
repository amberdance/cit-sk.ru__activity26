<?php

namespace App\Models;

use App\Models\Polls\PollResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 *  @property int $id
 *  @property int $district_id
 *  @property int $points
 *  @property bool $is_active
 *  @property bool $is_admin
 *  @property string $uuid
 *  @property string $fist_name
 *  @property string $last_mame
 *  @property string $patronymic
 *  @property string $address
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
        'id',
        'first_name',
        'last_name',
        'patronymic',
        'ip_address',
        'email',
        'address',
        'password',
        'is_active',
        'is_admin',
        'created_at',
        'updated_at',
        'email_verified_at'
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

    /**
     * @return HasMany
     */
    public function votes(): HasMany
    {
        return $this->hasMany(PollResult::class, 'user_id');
    }
}
