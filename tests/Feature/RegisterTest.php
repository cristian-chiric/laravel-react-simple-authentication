<?php

namespace Tests\Feature;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\FeatureTestCase;

class RegisterTest extends FeatureTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_can_register_and_login()
    {
        NoCaptcha::shouldReceive('verifyResponse')->andReturn(true);

        $this
            ->post(route('register.store'), [
                'name' => 'CC',
                'email' => 'cc@example.com',
                'password' => 'secret',
                'password_confirmation' => 'secret',
                'captcha' => '12345',
            ])
            ->assertResponseStatus(302)
            ->followRedirects()
            ->seeRouteIs('admin.dashboard');

        $this->seeInDatabase('users', [
            'name' => 'CC',
            'email' => 'cc@example.com',
        ]);

        $this
            ->json('POST', route('register.store'), [
                'name' => 'CC Json',
                'email' => 'cc_json@example.com',
                'password' => 'secret',
                'password_confirmation' => 'secret',
                'captcha' => '12345',
            ])
            ->assertResponseStatus(200);

        $this->seeInDatabase('users', [
            'name' => 'CC Json',
            'email' => 'cc_json@example.com',
        ]);
    }

    /** @test */
    public function it_cannot_register_without_data()
    {
        $this->expectException(ValidationException::class);
        $this->withoutExceptionHandling();
        $this->post(route('register.store'));
    }

    /** @test */
    public function it_cannot_register_without_a_name()
    {
        $this->expectException(ValidationException::class);
        $this->withoutExceptionHandling();
        $this->post(route('register.store'), [
            'email' => 'cc@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret']);
    }

    /** @test */
    public function it_cannot_register_without_a_valid_email()
    {
        $this->expectException(ValidationException::class);
        $this->withoutExceptionHandling();
        $this->post(route('register.store'), [
            'name' => 'cc',
            'email' => 'ccexample.com',
            'password' => 'secret',
            'password_confirmation' => 'secret']);
    }

    /** @test */
    public function it_cannot_register_with_an_existing_email()
    {
        $user = factory(User::class)->create();

        $this->expectException(ValidationException::class);
        $this->withoutExceptionHandling();
        $this->post(route('register.store'), [
            'name' => 'cc',
            'email' => $user->email,
            'password' => 'secret',
            'password_confirmation' => 'secret']);
    }

    /** @test */
    public function it_cannot_register_without_a_password()
    {
        $this->expectException(ValidationException::class);
        $this->withoutExceptionHandling();
        $this->post(route('register.store'), [
            'name' => 'cc',
            'email' => 'cc@example.com',
            'password' => null,
            'password_confirmation' => null]);
    }

    /** @test */
    public function it_cannot_register_if_password_is_not_confirmed()
    {
        $this->expectException(ValidationException::class);
        $this->withoutExceptionHandling();
        $this->post(route('register.store'), [
            'name' => 'cc',
            'email' => 'cc@example.com',
            'password' => 'secret',
            'password_confirmation' => 'sec']);
    }
}
