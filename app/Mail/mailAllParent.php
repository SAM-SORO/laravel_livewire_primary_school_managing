<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailAllParent extends Mailable
{
    use Queueable, SerializesModels;

    public $objet; // Sujet de l'e-mail
    public $message; // Contenu du message

    /**
     * Create a new message instance.
     *
     * @param string $objet
     * @param string $message
     */
    public function __construct($objet, $message)
    {
        $this->objet = $objet;
        $this->message = $message;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->objet)
                    ->html('<p>' . $this->message . '</p>');
    }
}
