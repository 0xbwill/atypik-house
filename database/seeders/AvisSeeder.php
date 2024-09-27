<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Avis;

class AvisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Avis::factory()->count(80)->create();
    }
}
