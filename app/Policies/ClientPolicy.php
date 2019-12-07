<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function create(): bool
    {
        return !auth()->guest();
    }

    public function view(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }

    public function update(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }
}
