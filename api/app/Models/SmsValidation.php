<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsValidation extends Model
{
    protected $fillable = ['verify_code', 'user_id', 'error_code', 'message_id', 'type', 'attempts'];
}
