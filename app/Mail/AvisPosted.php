<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Avis;

class AvisPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $avis;
    public $isHost;

    /**
     * Create a new message instance.
     */
    public function __construct(Avis $avis, $isHost = false)
    {
        $this->avis = $avis;
        $this->isHost = $isHost;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $view = $this->isHost ? 'emails.avis.avis-host' : 'emails.avis.avis-client';

        return $this->view($view)
                    ->subject('Nouveau commentaire posté sur un logement');
    }
}
