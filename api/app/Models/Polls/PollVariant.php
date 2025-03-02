<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *  @property int $id
 *  @property int $question_id
 *  @property int $sort
 *  @property string $label
 *  @property bool $has_user_answer
 */

class PollVariant extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'has_user_answer' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function questions(): BelongsTo
    {
        return $this->belongsTo(PollQuestion::class, 'question_id');
    }
}
