<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'user_id',
        'profile_picture',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFromUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function getProfilePictureAttribute(): ?string
    {
        if (empty($this->attributes['profile_picture'])) {
            return null;
        }

        return '/clients/' . $this->id . '/' . $this->attributes['profile_picture'];
    }
}
