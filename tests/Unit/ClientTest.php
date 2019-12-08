<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\User;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function a_client_can_get_his_user()
    {
        factory(User::class, 5)->create();
        $user = factory(User::class)->create();

        $client = factory(Client::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertEquals($user->fresh(), $client->fresh()->user);
    }
}
