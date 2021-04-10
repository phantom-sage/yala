<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'qualification',
        'educational_card_number',
        'educational_card_picture',
        'class',
        'subject',
        'address',
        'phone_number',
        'bank_name',
        'account_number',
        'password',
    ];
}
