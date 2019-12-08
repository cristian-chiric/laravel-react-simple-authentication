<?php

namespace App\Console\Commands;

use App\Emails\ClientListEmail;
use App\Models\Client;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendClientList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:client-list {--to-users} {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all clients to email';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('to-users')) {
            User::withClients()->get()->each(function(User $user): void {
                Mail::to($user->email)->send(new ClientListEmail($user->clients->sortBy('id')->values()->toArray()));
            });

            return;
        }

        $clients = Client::all()->toArray();

        Mail::to($this->argument('email') ?? config('mail.to.address'))
            ->send(new ClientListEmail($clients));
    }
}
