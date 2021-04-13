<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static first()
 * @method static find($id)
 * @method static where(string $string, $id)
 * @method static count()
 * @property mixed name
 * @property mixed qualification
 * @property mixed educational_card_number
 * @property mixed educational_card_picture
 * @property mixed class
 * @property mixed address
 * @property mixed phone_number
 * @property mixed bank_name
 * @property mixed account_number
 * @property mixed|string password
 * @property mixed id
 */
class Teacher extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'qualification',
        'educational_card_number',
        'educational_card_picture',
        'class',
        'address',
        'phone_number',
        'bank_name',
        'account_number',
        'password',
    ];

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
