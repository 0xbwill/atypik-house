<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_logement')->insert([['name' => 'Appartement'], ['name' => 'Maison'], ['name' => 'Studio'], ['name' => 'Loft'], ['name' => 'Duplex'], ['name' => 'Villa'], ['name' => 'Chalet'], ['name' => 'Bungalow'], ['name' => 'Tiny House']]);
    }
}
