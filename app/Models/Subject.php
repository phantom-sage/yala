<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 * @method static find(mixed $subject_id)
 * @method static count()
 * @property mixed name
 * @property mixed teacher_id
 */
class Subject extends Model
{
    use HasFactory;

    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class);
    }


    public function lessons()
    {
        return $this->hasMany(\App\Models\Lesson::class);
    }
}
