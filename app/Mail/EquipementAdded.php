<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Equipement;
use App\Models\CategoryLogement;
class EquipementAdded extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;

    public $equipement;
    public $category;

    /**
     * Create a new message instance.
     *
     * @param Equipement $equipement
     * @param CategoryLogement $category
     * @return void
     */
    public function __construct(Equipement $equipement, CategoryLogement $category)
    {
        $this->equipement = $equipement;
        $this->category = $category;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.equipement-added')
                    ->subject('Nouvel équipement ajouté à une catégorie');
    }
}
