<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $shop_id
 * @property int $user_id
 * @property int $number_of_stars
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Shop $shop
 * @property-read User $user
 */
class Rating extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'shop_id',
        'user_id',
        'number_of_stars',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Shop, self> */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, self> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
