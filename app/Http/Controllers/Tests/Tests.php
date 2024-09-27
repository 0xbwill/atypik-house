<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Logement\LogementController;
use App\Models\Avis;
use App\Models\Reservations;
use File;
use Illuminate\Http\Request;
use Stripe\Refund;
use Stripe\Stripe;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\User;

class Tests extends Controller
{
    public function serveIndex()
    {
        // Chemin absolu vers le fichier index.html dans app/Http/Controller/Tests/
        $path = app_path('Http/Controllers/Tests/index.html');
        
        // Vérifie si le fichier existe
        if (File::exists($path)) {
            return response()->file($path);
        }

        // Si le fichier n'existe pas, retourne une erreur 404
        return response()->json(['error' => 'Fichier index.html introuvable'], 404);
    }

    public function runTests($testName = null)
    {
        switch($testName) {
            case'AvisTest':
                $testResult = $this->postAvisTest(); // Appelle la méthode de test
                return response()->json($testResult, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            case'annulationReservationTest':
                $testResult = $this->annulationReservationTest();
                return response()->json($testResult, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            // autre cas de test unitaire
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Test non trouvé'
        ], 404);
    }


    public function postAvisTest()
    {
        $now = now();
        $user = User::where('email', 'user.dsp@gmail.com')->first();

        if ($user) {
            $avisPostes = $user->avis;
            $reservations = $user->reservations;
            $reservationsPasses = $reservations->filter(function ($reservation) use ($now) {
                return $reservation->fin_resa < $now;
            })->sortBy('debut_resa');
            
            $tabAvisPostes = [];
            $tabResaPasses = [];
            $idReservationAvecAvis = [];
            $idReservationSansAvis = [];

            // simplification des avis postés par l'utilisateur test
            foreach ($avisPostes as $avis) {
                $tabAvisPostes[] = [
                    "id" => $avis->id,
                    "logement_id" => $avis->logement_id,
                    "reservation_id" => $avis->reservations_id,
                    "comment" => $avis->comment
                ];
            }

            // simplification des reservations passées par l'utilisateur
            foreach($reservationsPasses as $reservationsP) {
                $tabResaPasses[] = [
                    "id" => $reservationsP->id,
                    "debut_resa" => $reservationsP->debut_resa,
                    "fin_resa" => $reservationsP->fin_resa,
                    "logement_id" => $reservationsP->logement_id
                ];
            }

            // on regroupe les reservations avec et sans avis
            foreach($reservationsPasses as $reservationsP) {
                if($reservationsP->avis->first()) {
                    $idReservationAvecAvis[] = $reservationsP->id;
                } else {
                    $idReservationSansAvis[] = $reservationsP->id;
                }
            }

            // on prend une reservation sans avis pour en ajouter un
            $idReservationPourAvisUnitaire = $idReservationSansAvis[0] ?? null;

            if(!is_null($idReservationPourAvisUnitaire)) {
                $avis = new Avis();
                $avis->reservations_id = $idReservationPourAvisUnitaire;
                $avis->logement_id = Reservations::find($idReservationPourAvisUnitaire)->logement_id;
                $avis->user_id = Reservations::find($idReservationPourAvisUnitaire)->user_id;
                $avis->rating = "3";
                $avis->comment = "Ceci est un commentaire de test unitaire";

                $avisUnitaire = $avis->save();
            }

            return [
                'TEST UNITAIRE : ' => 'Poster un avis',
                'Utilisateur de test' => $user->email,
                'Réservations passées' => $tabResaPasses,
                'Avis deja postés' => $tabAvisPostes,
                'Reservations sans avis' => $idReservationSansAvis,
                'Reservations avec avis' => $idReservationAvecAvis,
                'Id de reservation choisi pour le post unitaire' => $idReservationPourAvisUnitaire,
                'Avis pour test unitaire' => $avis,
                'RESULTAT POST UNITAIRE' => $avisUnitaire ?? "Aucun avis unitaire n'a pu être fait"
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Utilisateur non trouvé'
            ];
        }
    }

    public function annulationReservationTest() {
        $now = now();
        $user = User::where('email', 'user.dsp@gmail.com')->first();

        if ($user) {
            $avisPostes = $user->avis;
            $reservations = $user->reservations;
            $reservationsFutures = $reservations->filter(function ($reservation) use ($now) {
                return $reservation->debut_resa > $now;
            })->sortBy('debut_resa');
            
            $tabAvisPostes = [];
            $tabResaFutures = [];

            // simplification des reservations passées par l'utilisateur
            foreach($reservationsFutures as $reservationsF) {
                $tabResaFutures[] = [
                    "id" => $reservationsF->id,
                    "debut_resa" => $reservationsF->debut_resa,
                    "fin_resa" => $reservationsF->fin_resa,
                    "logement_id" => $reservationsF->logement_id
                ];
            }

            // simplification des avis postés par l'utilisateur test
            foreach ($avisPostes as $avis) {
                $tabAvisPostes[] = [
                    "id" => $avis->id,
                    "logement_id" => $avis->logement_id,
                    "reservation_id" => $avis->reservations_id,
                    "comment" => $avis->comment
                ];
            }

            // on prend au hasard une reservation à venir pour l'annuler
            if (!empty($tabResaFutures)) {
                // Choisir un élément aléatoire
                $randomIndex = array_rand($tabResaFutures);

                // Obtenir l'id de cet élément
                $idReservationPourAnnulationUnitaire = $tabResaFutures[$randomIndex]['id'];
            } else {
                $idReservationPourAnnulationUnitaire = null;
            }

            if(!is_null($idReservationPourAnnulationUnitaire)) {
                // Trouver la réservation
                $reservationPourAnnulationUnitaire = Reservations::findOrFail($idReservationPourAnnulationUnitaire);

                // Émettre un remboursement si le paiement existe
                if ($reservationPourAnnulationUnitaire->payment_status == 'paid' && $reservationPourAnnulationUnitaire->stripe_transaction_id) {
                    try {
                        // Initialiser Stripe
                        Stripe::setApiKey(env('STRIPE_SECRET'));

                        // Créer le remboursement
                        Refund::create([
                            'payment_intent' => $reservationPourAnnulationUnitaire->stripe_transaction_id,
                        ]);

                        // Mettre à jour le statut de paiement à 'refunded'
                        $reservationPourAnnulationUnitaire->payment_status = 'refunded';
                        $reservationPourAnnulationUnitaire->save();
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                }

                // Supprimer la réservation (cela définit la colonne deleted_at)
                $annulationReservationUnitaire = $reservationPourAnnulationUnitaire->delete();

                // Supprimer les avis liés à cette réservation
                foreach ($reservationPourAnnulationUnitaire->avis as &$avisClient) {
                    $avis = Avis::findOrFail($avisClient->id);
                    $avis->delete(); // Supprime également l'avis de l'utilisateur
                }

                $avisPostesApresAnnulationUnitaire = $user->avis;
            }

            return [
                'TEST UNITAIRE : ' => 'Annuler une réservation',
                'Utilisateur de test' => $user->email,
                'Réservations futures' => $tabResaFutures,
                'Avis deja postés' => $tabAvisPostes,
                'Id de reservation choisi pour le post unitaire' => $idReservationPourAnnulationUnitaire,
                'Réservation coisie pour annulation unitaire' => $reservationPourAnnulationUnitaire ?? "Aucune réservation à venir",
                'Avis apres annulation unitaire' => $avisPostesApresAnnulationUnitaire ?? "Aucun avis n'a pu être trouvé",
                'RESULTAT ANNULATION RESERVATION UNITAIRE' => $annulationReservationUnitaire ?? false,
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Utilisateur non trouvé'
            ];
        }
    }
}

