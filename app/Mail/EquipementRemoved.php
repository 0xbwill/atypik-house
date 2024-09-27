<?php

namespace App\Mail;

use App\Models\Equipement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EquipementRemoved extends Mailable
{
    use Queueable, SerializesModels;

    public $equipement;
    public $category;

    /**
     * Create a new message instance.
     */
    public function __construct(Equipement $equipement, $category)
    {
        $this->equipement = $equipement;
        $this->category = $category;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.equipement-removed')
                    ->with([
                        'equipementName' => $this->equipement->name,
                        'categoryName' => $this->category->name,
                    ]);
    }
}
