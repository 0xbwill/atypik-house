<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $prenom;
    public $telephone;
    public $email;
    public $formMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nom, $prenom, $telephone, $email, $formMessage)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->formMessage = $formMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nouveau message de contact')
            ->view('emails.contact')
            ->with([
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'telephone' => $this->telephone,
                'email' => $this->email,
                'formMessage' => $this->formMessage,
            ]);
    }
}
