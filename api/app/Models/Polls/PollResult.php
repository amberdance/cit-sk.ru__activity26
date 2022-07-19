<?php

namespace App\Models\Polls;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *  @property int $poll_id
 *  @property int $question_id
 *  @property int $variant_id
 *  @property string $user_uuid
 *  @property string $custom_answer
 */

class PollResult extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function questions(): BelongsTo
    {
        return $this->belongsTo(PollQuestion::class, 'question_id');
    }

    /**
     * @return HasMany
     */
    public function variants(): BelongsTo
    {
        return $this->belongsTo(PollVariant::class, 'variant_id');
    }

    /**
     * @return HasMany
     */
    public function polls(): BelongsTo
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

}
