<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\User;
use App\Repository\ClientRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class ClientRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(ClientRepository::class);
    }

    /**
     * @test
     */
    public function a_user_can_get_his_clients_only()
    {
        $user = factory(User::class)->create();
        factory(Client::class)->create(['name' => 'Tester', 'user_id' => 11]);

        $client2 = factory(Client::class)->create(['name' => 'Tester2', 'user_id' => $user->id]);

        $this->actingAs($user);
        $clients = $this->repository->all();
        $this->assertEquals(1, $clients->count());
        $this->assertEquals($client2->fresh(), $clients->first());
    }

    /**
     * @test
     */
    public function a_user_cannot_edit_another_users_client()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $client = factory(Client::class)->create(['name' => 'Tester', 'user_id' => $user2->id]);
        $client2 = factory(Client::class)->create(['name' => 'Tester2', 'user_id' => $user->id]);

        $this->actingAs($user);
        $this->expectException(ModelNotFoundException::class);
        $this->withoutExceptionHandling();
        $this->repository->update(['name' => 'Test'], $client->id);

        $this->assertEquals('Tester', $client->fresh()->name);
        $this->assertEquals('Tester2', $client2->fresh()->name);
    }

    /**
     * @test
     */
    public function a_user_can_edit_his_client()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create(['name' => 'Tester', 'user_id' => $user->id]);

        $this->actingAs($user);
        $this->repository->update(['name' => 'Test'], $client->id);

        $this->assertEquals('Test', $client->fresh()->name);
    }
}
