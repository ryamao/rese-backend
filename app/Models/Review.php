<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $shop_id
 * @property int $rating
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Shop $shop
 */
class Review extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'user_id',
        'shop_id',
        'rating',
        'comment',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, self> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Shop, self> */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
