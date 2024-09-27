<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservations;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Mail\PaymentConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    // construct function that redirect to homepage if user is not logged in
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function processPayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Créer un PaymentIntent avec une `return_url`
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->total_amount * 100, // Montant en cents
                'currency' => 'eur',
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'token' => $request->payment_method_id,
                    ],
                ],
                'confirmation_method' => 'automatic',
                'confirm' => true,
                'return_url' => route('reservation.success'),
            ]);

            if ($paymentIntent->status === 'succeeded') {
                // Récupérer la réservation temporaire
                $reservation = Reservations::findOrFail($request->reservation_id);

                // (backup, old version) Vérifier à nouveau que les dates sont toujours disponibles
                // $existingReservation = Reservations::where('logement_id', $reservation->logement_id)
                //     ->where(function ($query) use ($reservation) {
                //         $query->whereBetween('debut_resa', [$reservation->debut_resa, $reservation->fin_resa])
                //             ->orWhereBetween('fin_resa', [$reservation->debut_resa, $reservation->fin_resa])
                //             ->orWhere(function ($query) use ($reservation) {
                //                 $query->where('debut_resa', '<=', $reservation->debut_resa)
                //                     ->where('fin_resa', '>=', $reservation->fin_resa);
                //             });
                //     })
                //     ->where('payment_status', 'paid')
                //     ->exists();

                // if ($existingReservation) {
                //     return response()->json([
                //         'success' => false,
                //         'message' => 'Les dates sélectionnées ne sont plus disponibles.',
                //     ], 400);
                // }

                // Mise à jour de la réservation avec les détails du paiement
                $reservation->stripe_payment_intent_id = $paymentIntent->id;
                $reservation->stripe_transaction_id = $paymentIntent->id;
                $reservation->payment_status = 'paid';
                $reservation->payment_date = Carbon::now();
                $reservation->save();

                Mail::to($reservation->user->email)->send(new PaymentConfirmation($reservation));

                Mail::to($reservation->logement->user->email)->send(new PaymentConfirmation($reservation, true));
            }

            return response()->json([
                'success' => true,
                'status' => $paymentIntent->status,
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Erreur spécifique à l'API Stripe
            return response()->json([
                'success' => false,
                'message' => 'Stripe API Error: ' . $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            // Autres erreurs générales
            return response()->json([
                'success' => false,
                'message' => 'General Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function reservationSuccess()
    {
        // Récupérer la dernière réservation effectuée par le client
        $lastReservation = Reservations::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->where('payment_status', 'paid')
            ->first();

        // Vérifier si une réservation existe
        if ($lastReservation) {
            // Get Dates de séjour
            $lastReservation->startDate = Carbon::parse($lastReservation->debut_resa);
            $lastReservation->endDate = Carbon::parse($lastReservation->fin_resa);

            // Calcul du nombre de nuits
            $lastReservation->nights = $lastReservation->startDate->diffInDays($lastReservation->endDate);

            // Calcul du prix total
            $lastReservation->totalAmount = $lastReservation->logement->price * $lastReservation->nights;
        }

        // Passer la réservation à la vue (null si aucune réservation trouvée)
        return view('reservation-success', compact('lastReservation'));
    }
}
