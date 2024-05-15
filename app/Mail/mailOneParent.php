<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailOneParent extends Mailable
{
    use Queueable, SerializesModels;

    public $subject; // Sujet de l'email
    public $message; // Contenu du message

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->html('<p>' . $this->message . '</p>');
    }
}




