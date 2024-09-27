<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logement;
use Illuminate\Support\Facades\Auth;
use App\Models\Avis;
use Carbon\Carbon;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer les logements publiés uniquement
        $logements = Logement::where('published', 1)->take(10)->get();

        foreach ($logements as $logement) {
            $logement->public_url = preg_match('/^(http|https):\/\//', $logement->image_url) ? true : false;

            // Ajouter la note moyenne à chaque logement
            $logement->average_rating = $logement->averageRating();
        }

        // Récupérer les 15 meilleurs avis avec les relations nécessaires
        $filteredAvis = Avis::with(['user', 'logement', 'reservations'])
            ->orderBy('rating', 'desc')
            ->take(15)
            ->get();

        foreach ($filteredAvis as $avis) {
            if ($avis->reservations) {
                $debutResa = Carbon::parse($avis->reservations->debut_resa);
                $finResa = Carbon::parse($avis->reservations->fin_resa);
                $avis->interval = $finResa->diffInDays($debutResa);
            }
        }

        // Calculer les valeurs dynamiques pour les statistiques
        $totalLogements = Logement::where('published', 1)->count();
        $totalUsersWithHostRole = User::role('hôte')->count();
        $totalAvis = Avis::count();
        $averageRating = Avis::avg('rating');

        return view('homepage.home', compact('filteredAvis', 'logements', 'totalLogements', 'totalUsersWithHostRole', 'totalAvis', 'averageRating'));
    }

    public function guideHote() {
        return view('devenir-hote-guide');
    }
}
