<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *  @property int $id
 *  @property int $question_id
 *  @property string $label
 */

class PollVariant extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];
    protected $hidden  = [
        'question_id',
    ];
}
