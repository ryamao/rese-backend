<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $image_url
 * @property string $detail
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $owner
 * @property-read \App\Models\Area $area
 * @property-read \App\Models\Genre $genre
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Reservation> $reservations
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Review> $reviews
 */
class Shop extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = ['owner_id', 'area_id', 'genre_id', 'name', 'image_url', 'detail'];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, self> */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Area, self> */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Genre, self> */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Reservation> */
    public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Review> */
    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }
}
