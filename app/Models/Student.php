<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_name',
        'phone_number',
        'address',
        'bank_name',
        'account_number',
        'education_level',
        'class',
        'name',
        'password',
    ];

    // Options
    public function options(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Option::class);
    }
}
