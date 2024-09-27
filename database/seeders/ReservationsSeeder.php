<?php

namespace Database\Seeders;

use App\Models\Logement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logements = Logement::all();
        $users = User::all();

        if ($logements->isEmpty()) {
            throw new \Exception('Aucun logement dans la base de données.');
        }

        if ($users->isEmpty()) {
            throw new \Exception('Aucun utilisateur dans la base de données.');
        }

        foreach ($logements as $logement) {
            // Récupérer les créneaux disponibles pour ce logement
            $disponibilites = DB::table('dates_disponibles')
                ->where('logement_id', $logement->id)
                ->get();

            // Mélanger les créneaux disponibles et en sélectionner 10
            $disponibilites = $disponibilites->shuffle()->take(10);

            foreach ($disponibilites as $dispo) {
                $randomUser = $users->random();
                $startDate = Carbon::parse($dispo->debut_dispo);
                $endDate = Carbon::parse($dispo->fin_dispo);

                // Générer une réservation à l'intérieur du créneau disponible
                $reservationStartDate = $startDate->copy()->addDays(rand(0, $endDate->diffInDays($startDate) - 1));
                $reservationEndDate = (clone $reservationStartDate)->addDays(rand(1, min(14, $endDate->diffInDays($reservationStartDate))));

                $paymentDate = $reservationStartDate->copy()->subDays(7);

                // Calcul du nombre de nuits
                $nights = $reservationEndDate->diffInDays($reservationStartDate);

                // Calcul du prix total
                $totalAmount = $nights * $logement->price; // 'price' est supposé être un champ dans la table 'logements'

                // Insérer la réservation avec le montant total calculé
                DB::table('reservations')->insert([
                    'debut_resa' => $reservationStartDate,
                    'fin_resa' => $reservationEndDate,
                    'logement_id' => $logement->id,
                    'user_id' => $randomUser->id,
                    'total_amount' => $totalAmount, // Montant total calculé
                    'payment_date' => $paymentDate, // Date de paiement calculée
                    'created_at' => now(),
                    'updated_at' => now(),
                    'payment_status' => 'paid',
                ]);
            }
        }
    }
}
