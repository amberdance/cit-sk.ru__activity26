<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *  @property int $id
 *  @property int $category_id
 *  @property int $points
 *  @property int $sort
 *  @property string $label
 *  @property string $description
 *  @property string $image
 *  @property string $thumbnail
 *  @property string $active_from
 *  @property string $active_to
 *  @property string $created_at
 *  @property string $updated_at
 *  @property bool $is_active
 *  @property bool $is_ranged
 *  @property bool $is_completed
 */

class Poll extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'category_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'is_active'    => 'boolean',
        'is_popular'   => 'boolean',
        'is_ranged'    => 'boolean',
    ];

    /**
     * @param string $image
     *
     * @return string
     */
    public function getImageAttribute(string $image): string
    {
        return asset($image);
    }

    /**
     * @param string $image
     *
     * @return string
     */
    public function getThumbnailAttribute(string $image): string
    {

        return asset($image);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(PollCategory::class, 'category_id');
    }

    /**
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(PollQuestion::class, 'poll_id');
    }
}
