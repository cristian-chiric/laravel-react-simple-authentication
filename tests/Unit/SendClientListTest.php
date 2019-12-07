<?php

namespace Tests\Unit;

use App\Emails\ClientListEmail;
use App\Models\Client;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendClientListTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_send_email()
    {
        Mail::fake();
        $clients = factory(Client::class, 3)->create(['user_id' => rand(5, 1000)]);

        Artisan::call('send:client-list');

        Mail::assertSent(ClientListEmail::class, function (ClientListEmail $mail) use ($clients) {
            $this->assertEquals($mail->list, $clients->toArray());
            return true;
        });
    }
}
