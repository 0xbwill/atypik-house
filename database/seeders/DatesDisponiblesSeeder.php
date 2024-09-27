<?php

namespace Database\Seeders;

use App\Models\Logement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatesDisponiblesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logements = Logement::all();

        if ($logements->isEmpty()) {
            throw new \Exception('Aucun logement dans la base de données.');
        }

        foreach ($logements as $logement) {
            for ($i = 0; $i < 10; $i++) {
                $startDate = Carbon::now()->addDays(rand(-180, 180));
                // Changer la durée minimale pour qu'elle soit d'au moins 3 jours
                $endDate = (clone $startDate)->addDays(rand(4, 14)); // Changer le minimum de 1 à 3

                DB::table('dates_disponibles')->insert([
                    'debut_dispo' => $startDate,
                    'fin_dispo' => $endDate,
                    'logement_id' => $logement->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
