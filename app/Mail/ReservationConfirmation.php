<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservations;
use Carbon\Carbon;

class ReservationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $isHost;
    public $totalPrice; // Ajout de la propriété totalPrice

    /**
     * Create a new message instance.
     */
    public function __construct(Reservations $reservation, $isHost = false)
    {
        $this->reservation = $reservation;
        $this->isHost = $isHost;

        // Calculer le prix total
        $debut = Carbon::parse($this->reservation->debut_resa);
        $fin = Carbon::parse($this->reservation->fin_resa);
        $nights = $fin->diffInDays($debut);

        $this->totalPrice = $nights * $this->reservation->logement->price;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $view = $this->isHost ? 'emails.reservation.reservation-hote' : 'emails.reservation.reservation-client';

        return $this->view($view)
                    ->subject('Confirmation de réservation')
                    ->with([
                        'totalPrice' => $this->totalPrice, // Passer totalPrice à la vue
                    ]);
    }
}


