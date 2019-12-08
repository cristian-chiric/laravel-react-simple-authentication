<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function an_user_can_get_his_clients()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $others = factory(Client::class, 5)->create(['user_id' => $user2->id]);
        $clients = factory(Client::class, 5)->create(['user_id' => $user1->id]);

        $this->assertEquals($clients->sortBy('id')->values()->toArray(), $user1->clients->sortBy('id')->values()->toArray());
        $this->assertEquals($others->sortBy('id')->values()->toArray(), $user2->clients->sortBy('id')->values()->toArray());
    }

    /**
     * @test
     */
    public function can_retrieve_only_user_with_clients()
    {
        factory(User::class, 5)->create();
        $user = factory(User::class)->create();
        factory(Client::class, 5)->create(['user_id' => $user->id]);

        $users = User::withClients()->get();

        $this->assertEquals(1, $users->count());
        $this->assertEquals($user->id, $users->first()->id);
    }
}
