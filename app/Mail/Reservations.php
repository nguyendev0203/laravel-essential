<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reservations extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Undocumented function
     *
     * @param string $name
     */
    public function __construct(string $name = '')
    {
        //
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.reservation')
        ->with([
            'name' => $this->name,
        ]);
    }
}
