<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Logement;
use App\Models\Equipement;

class LogementEquipementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les logements avec leurs catégories
        $logements = Logement::with('category')->get();

        foreach ($logements as $logement) {
            // Récupérer les équipements autorisés pour la catégorie du logement
            $equipementsAutorises = $logement->category->equipements;

            if ($equipementsAutorises->isNotEmpty()) {
                // Déterminer le nombre d'équipements à sélectionner
                // Choisir un nombre aléatoire entre 1 et le nombre d'équipements autorisés disponibles
                $numberOfEquipements = rand(1, min(7, $equipementsAutorises->count()));

                // Sélectionner les équipements aléatoires parmi les équipements autorisés
                $randomEquipements = $equipementsAutorises->random($numberOfEquipements)->pluck('id');

                // Associer ces équipements au logement
                $logement->equipements()->attach($randomEquipements);
            }
        }
    }
}
