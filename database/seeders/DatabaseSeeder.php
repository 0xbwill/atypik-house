<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\About;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            EquipementsSeeder::class,
            LogementsTableSeeder::class,
            DatesDisponiblesSeeder::class,
            ReservationsSeeder::class,
            AvisSeeder::class,
            CategoryLogementEquipementSeeder::class,
            LogementEquipementSeeder::class,
        ]);

        About::create([]);
    }
}
