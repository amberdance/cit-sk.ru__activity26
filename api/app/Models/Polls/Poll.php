<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'category_id',
        'created_at',
        'updated_at',
    ];
}
