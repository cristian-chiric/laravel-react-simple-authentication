<?php

namespace App\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientListEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    public $list = [];

    public function __construct(array $list)
    {
        $this->list = $list;
    }

    public function build(): self
    {
        return $this
            ->subject('Clients list report')
            ->view('email.clients_list');
    }
}
