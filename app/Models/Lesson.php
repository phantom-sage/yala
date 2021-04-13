<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @method static first()
 * @method static find($id)
 * @property mixed id
 * @property mixed title
 * @property mixed description
 * @property mixed subject_id
 * @property mixed quiz
 */
class Lesson extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Get all of the lessons's pictures.
     */
    public function pictures(): MorphMany
    {
        return $this->morphMany(Picture::class, 'pictureable');
    }


    public function subject(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Subject::class);
    }
}
