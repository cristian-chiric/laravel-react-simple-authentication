<?php

namespace App\Console\Commands;

use App\Emails\ClientListEmail;
use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendClientList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:client-list {email?}';

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
        $clients = Client::withoutGlobalScope('owner')->get()->toArray();

        Mail::to($this->argument('email') ?? config('mail.to.address'))
            ->send(new ClientListEmail($clients));
    }
}
