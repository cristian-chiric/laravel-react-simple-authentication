<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('owner', function (Builder $builder) {
            $builder->where('user_id', '=', auth()->user()->id);
        });
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
