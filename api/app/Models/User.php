<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $fillable = ['name', 'surname', 'patronymic', 'phone', 'token', 'ip_address'];
}
