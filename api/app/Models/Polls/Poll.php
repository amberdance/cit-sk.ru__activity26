<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *  @property int $id
 *  @property int $category_id
 *  @property string $label
 *  @property string $description
 *  @property string $image
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

    /**
     * @param string $image
     *
     * @return string
     */
    public function getImageAttribute(string $image): string
    {
        return asset($image);
    }
}
