<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *  @property int $id
 *  @property string $label
 */

class PollCategory extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

}
