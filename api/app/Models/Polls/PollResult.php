<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Model;

/**
 *  @property string $user_uuid
 *  @property int $question_id
 *  @property int $variant_id
 */

class PollResult extends Model
{
    public $timestamps = false;

    protected $guarded = [];

}
