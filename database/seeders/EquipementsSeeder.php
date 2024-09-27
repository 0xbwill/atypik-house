<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipements = [
            ['name' => 'Piscine'],
            ['name' => 'Balcon'],
            ['name' => 'Climatisation'],
            ['name' => 'WiFi'],
            ['name' => 'Parking'],
            ['name' => 'Jardin'],
            ['name' => 'Terrasse'],
            ['name' => 'Lave-vaisselle'],
            ['name' => 'Machine à laver'],
            ['name' => 'Sèche-linge'],
            ['name' => 'Barbecue'],
            ['name' => 'Cheminée'],
            ['name' => 'Sauna'],
            ['name' => 'Gym'],
            ['name' => 'Ascenseur'],
            ['name' => 'Cave'],
            ['name' => 'Système de sécurité'],
            ['name' => 'Accessible PMR'],
            ['name' => 'Jacuzzi'],
            ['name' => 'Bureau'],
        ];

        DB::table('equipements')->insert($equipements);
    }
}
