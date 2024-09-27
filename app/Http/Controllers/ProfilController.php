<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfilController extends Controller
{
    public function show($slug)
    {
        // Charger l'utilisateur avec ses logements publiés et leurs avis en utilisant le slug
        $user = User::with([
            'logements' => function ($query) {
                $query->where('published', true);
            },
            'logements.avis'
        ])->where('slug', $slug)->firstOrFail();

        // Calculer le nombre d'avis et la note moyenne pour les logements
        $totalAvis = 0;
        $totalRating = 0;
        foreach ($user->logements as $logement) {
            $totalAvis += $logement->avis->count();
            $totalRating += $logement->avis->sum('rating');

            // Vérifier si l'URL de l'image est externe
            $logement->public_url = preg_match('/^(http|https):\/\//', $logement->image_url) ? true : false;
        }
        $averageRating = $totalAvis ? $totalRating / $totalAvis : 0;

        // Si l'utilisateur n'a pas de logements, on récupère ses avis
        $userAvis = null;
        $totalUserAvis = 0;
        $averageUserRating = 0;
        if ($user->logements->isEmpty()) {
            $userAvis = $user->avis()->with('logement')->get();
            $totalUserAvis = $userAvis->count();
            $averageUserRating = $totalUserAvis ? $userAvis->avg('rating') : 0;
        }

        return view('profil.profil-show', compact('user', 'totalAvis', 'averageRating', 'userAvis', 'totalUserAvis', 'averageUserRating'));
    }


    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Supprimer l'ancienne photo de profil si elle existe
        if ($user->profile_photo_path) {
            Storage::delete('public' . $user->profile_photo_path);
        }

        // Stocker la nouvelle photo
        $path = $request->file('photo')->store('profile_photos', 'public');

        // Mettre à jour le modèle utilisateur
        $user->profile_photo_path = $path;
        $user->save();

        return redirect()->back()->with('success', 'Profile photo updated successfully.');
    }
}
