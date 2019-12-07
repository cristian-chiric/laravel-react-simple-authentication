<?php

namespace Tests\Feature;

use App\Models\User;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\FeatureTestCase;

class AuthTest extends FeatureTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_can_login_with_right_credentials()
    {
        $user = factory(User::class)->create();

        $this
            ->post(route('login.store'), ['email' => $user->email, 'password' => 'secret'])
            ->assertResponseStatus(302)
            ->followRedirects()
            ->seeRouteIs('admin.dashboard')
            ->see($user->name);
    }

    /** @test */
    public function it_cannot_login_with_wrong_credentials()
    {
        $user = factory(User::class)->create();

        $this
            ->visitRoute('login.index')
            ->post(route('login.store'), ['email' => $user->email, 'password' => 'secret2'])
            ->assertResponseStatus(302)
            ->followRedirects()
            ->seeRouteIs('login.index');

        $this
            ->visitRoute('admin.dashboard')
            ->seeRouteIs('login.index');

        $this
            ->post(route('login.store'), ['email' => 'test@test.com', 'password' => 'secret'])
            ->assertResponseStatus(302)
            ->followRedirects()
            ->seeRouteIs('login.index');

        $this
            ->visitRoute('admin.dashboard')
            ->seeRouteIs('login.index');

        $response = $this->json('POST', route('login.store'), ['email' => 'test@test.com']);
        $this->assertResponseStatus(422);
        $this->assertMatchesSnapshot($response->response->getContent());

        $response = $this->json('POST', route('login.store'), ['password' => 'secret']);
        $this->assertResponseStatus(422);
        $this->assertMatchesSnapshot($response->response->getContent());

        $response = $this->json('POST', route('login.store'), ['email' => $user->email, 'password' => 'secret']);
        $this->assertResponseStatus(200);
        $this->assertMatchesSnapshot($response->response->getContent());
    }

    /** @test */
    public function it_can_access_admin_dashboard_if_logged_in()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->visitRoute('admin.dashboard')
            ->seeRouteIs('admin.dashboard');
    }

    /** @test */
    public function it_cannot_access_admin_dashboard_if_not_logged_in()
    {
        $this
            ->visitRoute('admin.dashboard')
            ->seeRouteIs('login.index');
    }
}
