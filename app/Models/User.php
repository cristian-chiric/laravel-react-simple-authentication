<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var array
     */
    protected $with = [
        'clients',
    ];

    /**
     * Add a mutator to ensure hashed passwords
     *
     * @var string
     */
    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function scopeWithClients(Builder $query): Builder
    {
        return $query->has('clients');
    }
}
