<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryLogementEquipementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les IDs des catégories de logements
        $categories = DB::table('category_logement')->pluck('id', 'name')->all();

        // Récupérer les IDs des équipements
        $equipements = DB::table('equipements')->pluck('id', 'name')->all();

        // Associer les équipements aux catégories de logements
        $categoryLogementEquipement = [
            // Maison
            ['category_logement_id' => $categories['Maison'], 'equipement_id' => $equipements['Piscine']],
            ['category_logement_id' => $categories['Maison'], 'equipement_id' => $equipements['Climatisation']],
            ['category_logement_id' => $categories['Maison'], 'equipement_id' => $equipements['WiFi']],
            ['category_logement_id' => $categories['Maison'], 'equipement_id' => $equipements['Jardin']],
            ['category_logement_id' => $categories['Maison'], 'equipement_id' => $equipements['Cheminée']],
            ['category_logement_id' => $categories['Maison'], 'equipement_id' => $equipements['Barbecue']],
            ['category_logement_id' => $categories['Maison'], 'equipement_id' => $equipements['Terrasse']],

            // Appartement
            ['category_logement_id' => $categories['Appartement'], 'equipement_id' => $equipements['Balcon']],
            ['category_logement_id' => $categories['Appartement'], 'equipement_id' => $equipements['Climatisation']],
            ['category_logement_id' => $categories['Appartement'], 'equipement_id' => $equipements['WiFi']],
            ['category_logement_id' => $categories['Appartement'], 'equipement_id' => $equipements['Ascenseur']],
            ['category_logement_id' => $categories['Appartement'], 'equipement_id' => $equipements['Parking']],

            // Studio
            ['category_logement_id' => $categories['Studio'], 'equipement_id' => $equipements['WiFi']],
            ['category_logement_id' => $categories['Studio'], 'equipement_id' => $equipements['Climatisation']],

            // Loft
            ['category_logement_id' => $categories['Loft'], 'equipement_id' => $equipements['WiFi']],
            ['category_logement_id' => $categories['Loft'], 'equipement_id' => $equipements['Climatisation']],
            ['category_logement_id' => $categories['Loft'], 'equipement_id' => $equipements['Gym']],
            ['category_logement_id' => $categories['Loft'], 'equipement_id' => $equipements['Ascenseur']],

            // Duplex
            ['category_logement_id' => $categories['Duplex'], 'equipement_id' => $equipements['Balcon']],
            ['category_logement_id' => $categories['Duplex'], 'equipement_id' => $equipements['Climatisation']],
            ['category_logement_id' => $categories['Duplex'], 'equipement_id' => $equipements['WiFi']],
            ['category_logement_id' => $categories['Duplex'], 'equipement_id' => $equipements['Terrasse']],

            // Villa
            ['category_logement_id' => $categories['Villa'], 'equipement_id' => $equipements['Piscine']],
            ['category_logement_id' => $categories['Villa'], 'equipement_id' => $equipements['Jardin']],
            ['category_logement_id' => $categories['Villa'], 'equipement_id' => $equipements['Climatisation']],
            ['category_logement_id' => $categories['Villa'], 'equipement_id' => $equipements['WiFi']],
            ['category_logement_id' => $categories['Villa'], 'equipement_id' => $equipements['Barbecue']],
            ['category_logement_id' => $categories['Villa'], 'equipement_id' => $equipements['Terrasse']],
            ['category_logement_id' => $categories['Villa'], 'equipement_id' => $equipements['Jacuzzi']],

            // Chalet
            ['category_logement_id' => $categories['Chalet'], 'equipement_id' => $equipements['Cheminée']],
            ['category_logement_id' => $categories['Chalet'], 'equipement_id' => $equipements['WiFi']],
            ['category_logement_id' => $categories['Chalet'], 'equipement_id' => $equipements['Sauna']],
            ['category_logement_id' => $categories['Chalet'], 'equipement_id' => $equipements['Barbecue']],

            // Bungalow
            ['category_logement_id' => $categories['Bungalow'], 'equipement_id' => $equipements['Climatisation']],
            ['category_logement_id' => $categories['Bungalow'], 'equipement_id' => $equipements['WiFi']],
            ['category_logement_id' => $categories['Bungalow'], 'equipement_id' => $equipements['Terrasse']],
            ['category_logement_id' => $categories['Bungalow'], 'equipement_id' => $equipements['Jardin']],

            // Tiny House
            ['category_logement_id' => $categories['Tiny House'], 'equipement_id' => $equipements['WiFi']],
            ['category_logement_id' => $categories['Tiny House'], 'equipement_id' => $equipements['Climatisation']],
            ['category_logement_id' => $categories['Tiny House'], 'equipement_id' => $equipements['Jardin']],
        ];

        DB::table('category_logement_equipement')->insert($categoryLogementEquipement);
    }
}
