<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
    ];

    /**
     * Get the parent pictureable model (lesson).
     */
    public function pictureable()
    {
        return $this->morphTo();
    }
}
