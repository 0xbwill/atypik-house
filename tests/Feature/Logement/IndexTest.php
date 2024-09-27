<?php

use App\Models\User;
use App\Models\CategoryLogement;
use App\Models\Logement;
use Illuminate\Support\Str;
use function Pest\Laravel\get;
use function Pest\Laravel\artisan;

it('displays logement details', function () {
    // Exécuter les seeders pour s'assurer que les données existent
    artisan('db:seed');

    // Récupérer un utilisateur et une catégorie existants
    $user = User::whereHas('roles', function ($query) {
        $query->whereIn('name', ['admin', 'hôte']);
    })->first();

    $category = CategoryLogement::first();

    // Créer un logement avec l'utilisateur et la catégorie existants
    $logement = Logement::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'slug' => 'logement-' . Str::random(6),
    ]);

    $response = get(route('logement.index', $logement->slug));

    $response->assertStatus(200);
    $response->assertViewIs('logement.index');
    $response->assertViewHas('logement', function ($viewLogement) use ($logement) {
        return $viewLogement->slug === $logement->slug;
    });
});
