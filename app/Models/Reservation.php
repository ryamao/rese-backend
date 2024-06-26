<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property int $shop_id
 * @property \Illuminate\Support\Carbon $reserved_at
 * @property int $number_of_guests
 * @property bool $is_checked_in
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Shop $shop
 * @property-read \App\Models\Billing|null $billing
 */
class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    /** @var array<int, string> */
    protected $fillable = [
        'user_id',
        'shop_id',
        'reserved_at',
        'number_of_guests',
        'is_checked_in',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'reserved_at' => 'datetime',
        'is_checked_in' => 'boolean',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, self> */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Shop, self> */
    public function shop(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Billing> */
    public function billing(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Billing::class);
    }
}
