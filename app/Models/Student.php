<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static first()
 * @method static count()
 * @method static find($id)
 * @method static where(string $string, $id)
 * @property mixed parent_name
 * @property mixed phone_number
 * @property mixed address
 * @property mixed bank_name
 * @property mixed account_number
 * @property mixed education_level
 * @property mixed class
 * @property mixed name
 * @property mixed|string password
 */
class Student extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
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

}
