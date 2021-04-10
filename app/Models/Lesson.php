<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Get all of the lessons's pictures.
     */
    public function pictures()
    {
        return $this->morphMany(Picture::class, 'pictureable');
    }
}
