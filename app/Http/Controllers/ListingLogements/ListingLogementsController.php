<?php

namespace App\Http\Controllers\ListingLogements;

use App\Http\Controllers\Controller;
use App\Models\Logement;
use Illuminate\Http\Request;

class ListingLogementsController extends Controller
{
    public function index()
    {
        // Récupérer les logements publiés avec pagination et ayant des avis
        $perPage = 9; // Nombre de logements par page
        $paginatedLogements = Logement::where('published', 1)->has('avis')->with('avis')->paginate($perPage);

        // Calculer la note moyenne pour chaque logement et déterminer si l'image est externe
        foreach ($paginatedLogements as $logement) {
            $logement->average_rating = $logement->averageRating();
            $logement->public_url = preg_match('/^(http|https):\/\//', $logement->image_url) ? true : false;
        }

        // Trier les logements par note moyenne en ordre décroissant et prendre les 10 premiers
        $topRatedLogements = $paginatedLogements->sortByDesc('average_rating')->take(10);

        // Passer les logements paginés, triés et tous les logements à la vue
        return view('logements.index', [
            'topRatedLogements' => $topRatedLogements,
            'paginatedLogements' => $paginatedLogements
        ]);
    }
}
