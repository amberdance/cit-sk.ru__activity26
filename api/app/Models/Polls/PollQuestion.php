<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *  @property int $id
 *  @property int $poll_id
 *  @property string $label
 */

class PollQuestion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];
    protected $hidden  = [
        'poll_id',
    ];

    /**
     * @return HasMany
     */
    public function variants(): HasMany
    {
        return $this->hasMany(PollVariant::class, 'question_id')->orderBy('sort');
    }

}
