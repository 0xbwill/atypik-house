<?php

namespace App\Http\Controllers\Logement;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Logement;
use App\Models\Reservations;
use App\Models\Avis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\CategoryLogement;
use App\Models\Equipement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationCancellation;
use App\Mail\AvisPosted;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Stripe\Stripe;
use Stripe\Refund;


class LogementController extends Controller
{

    /**
     * Affiche les détails d'un logement.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $logement = Logement::where('slug', $slug)->firstOrFail();

        // Vérifier si l'URL de l'image est externe pour le logement principal
        $logement->public_url = preg_match('/^(http|https):\/\//', $logement->image_url) ? true : false;

        if ($logement->published == 0 && (auth()->user() == null || auth()->user()->id != $logement->user_id)) {
            return redirect()->route('home.index');
        }

        // Récupération des avis du logement et affectation d'un interval
        $avisDuLogement = $logement->avis;
        foreach ($avisDuLogement as $avis) {
            if ($avis->reservations) {
                $debutResa = Carbon::parse($avis->reservations->debut_resa);
                $finResa = Carbon::parse($avis->reservations->fin_resa);
                $avis->interval = $finResa->diffInDays($debutResa);
            }
        }
        $datesDuLogement = $logement->datesDispos;

        // Récupérer les réservations associées au logement
        $reservations = $logement->reservations()->get(['debut_resa', 'fin_resa']);

        // Formater les réservations pour le JavaScript
        $datesReservees = $reservations->map(function ($reservation) {
            $debut = Carbon::parse($reservation->debut_resa);
            $fin = Carbon::parse($reservation->fin_resa);

            return [
                'debut_dispo' => $debut->format('Y-m-d'),
                'fin_dispo' => $fin->format('Y-m-d'),
            ];
        });

        $countAvis = $avisDuLogement->count();
        $ratingLogement = $avisDuLogement->sum('rating');
        $averageRating = $countAvis ? $ratingLogement / $countAvis : 0;

        $logementsSimilaires = Logement::where('category_id', $logement->category_id)
            ->where('slug', '!=', $slug)
            ->where('published', 1)
            ->inRandomOrder()
            ->take(3)
            ->get();

        foreach ($logementsSimilaires as $logementSimilaire) {
            // Vérifier si l'URL de l'image est externe pour les logements similaires
            $logementSimilaire->public_url = preg_match('/^(http|https):\/\//', $logementSimilaire->image_url) ? true : false;

            $avisDuLogementSimilaire = $logementSimilaire->avis;
            $countAvisSimilaire = $avisDuLogementSimilaire->count();
            $ratingLogementSimilaire = $avisDuLogementSimilaire->sum('rating');
            $averageRatingSimilaire = $countAvisSimilaire ? $ratingLogementSimilaire / $countAvisSimilaire : 0;

            // Ajout de la note moyenne
            $logementSimilaire->averageRating = $averageRatingSimilaire;
        }

        return response()->view('logement.index', [
            'logement' => $logement,
            'avisDuLogement' => $avisDuLogement,
            'countAvis' => $countAvis,
            'datesDuLogement' => $datesDuLogement,
            'averageRating' => $averageRating,
            'logementsSimilaires' => $logementsSimilaires,
            'datesReservees' => $datesReservees,
        ]);
    }

    public function mesLogements()
    {
        $logements = auth()->user()->logements;

        // Ajouter la propriété dynamique `public_url` à chaque logement
        foreach ($logements as $logement) {
            // Vérifier si l'URL est externe
            if (preg_match('/^(http|https):\/\//', $logement->image_url)) {
                $logement->public_url = true;
            } else {
                $logement->public_url = false;
            }
        }

        $logementsPubliés = $logements->where('published', 1);
        $logementsNonPubliés = $logements->where('published', 0);

        return view('logements.mes-logements', [
            'logementsPubliés' => $logementsPubliés,
            'logementsNonPubliés' => $logementsNonPubliés,
        ]);
    }

    public function destroyLogement($id)
    {
        $logement = Logement::findOrFail($id);

        $logement->avis()->delete();


        // Supprimer l'image principale
        if ($logement->image_url && Storage::exists('public/' . $logement->image_url)) {
            Storage::delete('public/' . $logement->image_url);
        }

        // Supprimer les images secondaires
        foreach ($logement->images as $image) {
            if (Storage::exists('public/' . $image->url)) {
                Storage::delete('public/' . $image->url);
            }
            $image->delete();
        }

        // Supprimer le logement
        $logement->delete();

        return redirect()->route('mes-logements.index')->with('success', 'Logement supprimé avec succès.');
    }


    public function listingReservations($id)
    {
        // Récupérer les réservations et effectuer les calculs nécessaires
        $reservations = Reservations::where('logement_id', $id)
            ->with(['user', 'logement'])
            ->get()
            ->map(function ($reservation) {
                // Calcul du nombre de nuits réservées
                $debut = Carbon::parse($reservation->debut_resa);
                $fin = Carbon::parse($reservation->fin_resa);
                $reservation->nights = $fin->diffInDays($debut);

                // Calcul du prix total
                $reservation->totalPrice = $reservation->nights * $reservation->logement->price;

                return $reservation;
            });

        $logement = Logement::findOrFail($id);

        // Vérification que l'utilisateur est bien le propriétaire du logement
        if ($logement->user_id !== Auth::user()->id) {
            return redirect()->route('home.index');
        }

        // Grouper les réservations par mois et trier par année/mois
        $reservationsByMonth = $reservations->groupBy(function ($reservation) {
            return Carbon::parse($reservation->debut_resa)->format('Y-m');
        })->sortBy(function ($reservations, $month) {
            return Carbon::parse($month)->format('Y-m');
        });

        return view('logements.hote.listing-reservations', [
            'reservationsByMonth' => $reservationsByMonth,
            'logement' => $logement,
        ]);
    }


    public function mesReservations()
    {
        $now = now();
        $reservations = Reservations::where('user_id', auth()->id())
            ->where('payment_status', '!=', 'pending') // Exclure les réservations avec le statut 'pending'
            ->with([
                'logement',
                'logement.avis' => function ($query) {
                    $query->where('user_id', auth()->id());
                },
            ])
            ->get();

        // Fonction pour compter le nb de nuits resa + formater date debut et fin pour vue user
        $reservations = $this->mappageDatesReservations($reservations);

        // Vérifier si l'URL de l'image est externe pour chaque logement
        foreach ($reservations as $reservation) {
            $logement = $reservation->logement;
            if ($logement) {
                $logement->public_url = preg_match('/^(http|https):\/\//', $logement->image_url) ? true : false;
            }
        }

        $pastReservations = $reservations->filter(function ($reservation) use ($now) {
            return $reservation->fin_resa < $now;
        })->sortBy('debut_resa');

        $currentReservations = $reservations->filter(function ($reservation) use ($now) {
            return $reservation->debut_resa <= $now && $reservation->fin_resa >= $now;
        })->sortBy('debut_resa');

        $upcomingReservations = $reservations->filter(function ($reservation) use ($now) {
            return $reservation->debut_resa > $now;
        })->sortBy('debut_resa');

        foreach ($upcomingReservations as $reservation) {
            $reservationStartDate = \Carbon\Carbon::createFromFormat('d/m/Y', $reservation->resa_debut);
            $daysDifference = $reservationStartDate->diffInDays($now);
            $reservation->is_cancellable = $daysDifference >= 7;
        }

        $mesAvis = Avis::where('user_id', auth()->id())->get();

        $cancelledReservations = $this->showCancelledReservations();

        return view('logements.mes-reservations', [
            'pastReservations' => $pastReservations,
            'currentReservations' => $currentReservations,
            'upcomingReservations' => $upcomingReservations,
            'mesAvis' => $mesAvis,
            'cancelledReservations' => $cancelledReservations,
        ]);
    }

    public function cancelReservation($id)
    {
        // Trouver la réservation
        $reservation = Reservations::findOrFail($id);

        // Émettre un remboursement si le paiement existe
        if ($reservation->payment_status == 'paid' && $reservation->stripe_transaction_id) {
            try {
                // Initialiser Stripe
                Stripe::setApiKey(env('STRIPE_SECRET'));

                // Créer le remboursement
                Refund::create([
                    'payment_intent' => $reservation->stripe_transaction_id,
                ]);

                // Mettre à jour le statut de paiement à 'refunded'
                $reservation->payment_status = 'refunded';
                $reservation->save();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Échec du remboursement : ' . $e->getMessage());
            }
        }

        // Supprimer la réservation (cela définit la colonne deleted_at)
        $reservation->delete();

        // Supprimer les avis liés à cette réservation
        foreach ($reservation->avis as &$avisClient) {
            $avis = Avis::findOrFail($avisClient->id);
            $avis->delete(); // Supprime également l'avis de l'utilisateur
        }

        // Envoyer un email de notification au client
        Mail::to($reservation->user->email)->send(new ReservationCancellation($reservation));

        // Envoyer un email de notification à l'hôte
        Mail::to($reservation->logement->user->email)->send(new ReservationCancellation($reservation, true));

        return redirect()->back()->with('success', 'Réservation annulée et remboursée avec succès.');
    }


    public function showCancelledReservations()
    {
        $cancelledReservations = $this->mappageDatesReservations(Reservations::onlyTrashed()->get())
            ->where('user_id', '=', Auth::user()->id)
            ->sortByDesc('deleted_at');

        foreach ($cancelledReservations as &$reservation) {
            if ($reservation->logement) {
                $reservation->logement->public_url = preg_match('/^(http|https):\/\//', $reservation->logement->image_url) ? true : false;
            }
        }

        return $cancelledReservations;
    }

    private function mappageDatesReservations($reservations)
    {
        $reservations->map(function ($reservation) {
            // Calcul du nombre de nuits réservées
            $debut = Carbon::parse($reservation->debut_resa);
            $fin = Carbon::parse($reservation->fin_resa);
            $reservation->nights = $fin->diffInDays($debut);

            // nouveaux champs pour affichage date vue et ainsi garder ceux de base pour les filtres (comparaison avec now)
            $reservation->resa_debut = $debut->format("d/m/Y");
            $reservation->resa_fin = $fin->format("d/m/Y");

            // Calcul du prix total
            $reservation->totalPrice = $reservation->nights * $reservation->logement->price;

            return $reservation;
        });
        return $reservations;
    }

    public function createLogement()
    {
        $categories = CategoryLogement::all();
        return view('logements.create', compact('categories'));
    }

    public function storeLogement(Request $request)
    {
        $messages = [
            'title.required' => 'Le titre est obligatoire.',
            'title.unique' => 'Ce titre a déjà été utilisé.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'short_description.required' => 'La description courte est obligatoire.',
            'short_description.min' => 'La description courte doit contenir au moins 10 caractères.',
            'short_description.max' => 'La description courte ne peut pas dépasser 80 caractères.',
            'description.required' => 'La description complète est obligatoire.',
            'description.min' => 'La description complète doit contenir au moins 10 caractères.',
            'description.max' => 'La description complète ne peut pas dépasser 255 caractères.',
            'price.required' => 'Le prix est obligatoire.',
            'price.integer' => 'Le prix doit être un nombre entier.',
            'capacity.required' => 'La capacité est obligatoire.',
            'capacity.integer' => 'La capacité doit être un nombre entier.',
            'bedrooms.required' => 'Le nombre de chambres est obligatoire.',
            'bedrooms.integer' => 'Le nombre de chambres doit être un nombre entier.',
            'bathrooms.required' => 'Le nombre de salles de bain est obligatoire.',
            'bathrooms.integer' => 'Le nombre de salles de bain doit être un nombre entier.',
            'category_id.required' => 'La catégorie est obligatoire.',
            'category_id.integer' => 'La catégorie doit être un identifiant valide.',
            'image.required' => 'L\'image principale est obligatoire.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'Le fichier doit être de type : jpeg, png, jpg, gif, svg.',
            'image.max' => 'L\'image ne peut pas dépasser 2 Mo.',
            'images.*.image' => 'Chaque fichier doit être une image.',
            'images.*.mimes' => 'Chaque fichier doit être de type : jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'Chaque image ne peut pas dépasser 2 Mo.',
            'pet_allowed.in' => 'Le champ "Animaux acceptés" doit être "yes" ou "no".',
            'smoker_allowed.in' => 'Le champ "Fumeurs acceptés" doit être "yes" ou "no".',
            'city.max' => 'La ville ne peut pas dépasser 255 caractères.',
            'country.max' => 'Le pays ne peut pas dépasser 255 caractères.',
            'street.max' => 'La rue ne peut pas dépasser 255 caractères.',
            'postal_code.max' => 'Le code postal ne peut pas dépasser 255 caractères.',
        ];


        $validatedData = $request->validate([
            'title' => 'required|unique:logements,title|string|max:255',
            'short_description' => 'required|string|min:10',
            'description' => 'required|string|min:10',
            'price' => 'required|integer',
            'capacity' => 'required|integer',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'category_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pet_allowed' => 'nullable|string|in:yes,no',
            'smoker_allowed' => 'nullable|string|in:yes,no',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
        ], $messages);

        $validatedData['slug'] = Str::slug($validatedData['title']);

        $logement = new Logement($validatedData);
        $logement->user_id = auth()->id();
        $logement->save();

        // Gestion de l'image principale
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $filename, 'public');

            // Optimiser l'image principale
            $fullPath = storage_path('app/public/' . $path);
            OptimizerChainFactory::create()->optimize($fullPath);

            $logement->image_url = $path; // Enregistrer le chemin correct sans "storage/"
            $logement->save();
        }

        // Gestion des images secondaires
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('images', $filename, 'public');

                // Optimiser chaque image secondaire
                $fullPath = storage_path('app/public/' . $path);
                OptimizerChainFactory::create()->optimize($fullPath);

                // Enregistrer chaque image secondaire avec le bon chemin
                $logement->images()->create(['url' => $path]);
            }
        }

        return redirect()
            ->route('logement.index', $logement->slug)
            ->with('success', 'Logement créé avec succès.');
    }



    public function editLogement($id)
    {
        $logement = Logement::with('images')->findOrFail($id);

        // Vérifier que l'utilisateur est bien le propriétaire du logement
        if ($logement->user_id !== Auth::user()->id) {
            return redirect()->route('home.index');
        }

        $categories = CategoryLogement::all();

        // Charger les équipements disponibles si cela est nécessaire pour l'édition
        $availableEquipements = Equipement::whereHas('categoriesLogement', function ($query) use ($logement) {
            $query->where('category_logement_id', $logement->category_id);
        })->get();

        return view('logement.edit', [
            'logement' => $logement,
            'categories' => $categories,
            'availableEquipements' => $availableEquipements,
        ]);
    }

    public function updateLogement($id)
    {
        $logement = Logement::findOrFail($id);

        $messages = [
            'title.required' => 'Le titre est obligatoire.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'short_description.required' => 'La description courte est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'price.required' => 'Le prix est obligatoire.',
            'price.integer' => 'Le prix doit être un nombre entier.',
            'capacity.required' => 'La capacité est obligatoire.',
            'capacity.integer' => 'La capacité doit être un nombre entier.',
            'bedrooms.required' => 'Le nombre de chambres est obligatoire.',
            'bedrooms.integer' => 'Le nombre de chambres doit être un nombre entier.',
            'bathrooms.required' => 'Le nombre de salles de bain est obligatoire.',
            'bathrooms.integer' => 'Le nombre de salles de bain doit être un nombre entier.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'Le fichier doit être de type : jpeg, png, jpg, gif, svg.',
            'image.max' => 'L\'image ne peut pas dépasser 2 Mo.',
            'images.*.image' => 'Chaque fichier doit être une image.',
            'images.*.mimes' => 'Chaque fichier doit être de type : jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'Chaque image ne peut pas dépasser 2 Mo.',
            // 'category_id.required' => 'La catégorie est obligatoire.',
            // 'category_id.integer' => 'La catégorie doit être un identifiant valide.',
            'pet_allowed.string' => 'Le champ "Animaux acceptés" doit être une chaîne de caractères.',
            'smoker_allowed.string' => 'Le champ "Fumeurs acceptés" doit être une chaîne de caractères.',
            'city.max' => 'La ville ne peut pas dépasser 255 caractères.',
            'country.max' => 'Le pays ne peut pas dépasser 255 caractères.',
            'street.max' => 'La rue ne peut pas dépasser 255 caractères.',
            'postal_code.max' => 'Le code postal ne peut pas dépasser 255 caractères.',
            'equipements.array' => 'Les équipements doivent être un tableau.',
            'equipements.*.exists' => 'Certains équipements sélectionnés n\'existent pas.',
            'description.min' => 'La description doit contenir au moins 10 caractères.',
            'description.max' => 'La description ne peut pas depasser 255 caractères.',
            'short_description.min' => 'La description courte doit contenir au moins 10 caractères.',
            'short_description.max' => 'La description courte ne peut pas depasser 80 caractères.',
        ];

        $validatedData = request()->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|min:10',
            'description' => 'required|string|min:10',
            'price' => 'required|integer',
            'capacity' => 'required|integer',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'category_id' => 'required|integer',
            'pet_allowed' => 'nullable|string',
            'smoker_allowed' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'equipements' => 'nullable|array',
            'equipements.*' => 'exists:equipements,id',
        ], $messages);

        // Générer le slug à partir du titre modifié
        $validatedData['slug'] = Str::slug($validatedData['title'], '-');

        $validatedData['published'] = request()->has('published');

        // Mise à jour des données du logement
        $logement->update($validatedData);

        // Gestion de l'image principale
        if (request()->hasFile('image')) {
            $image = request()->file('image');

            // Supprimer l'ancienne image si elle existe
            if ($logement->image_url && Storage::exists('public/' . $logement->image_url)) {
                Storage::delete('public/' . $logement->image_url);
            }

            // Enregistrer la nouvelle image principale
            $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);

            // Utiliser forceFill pour contourner le mutator
            $logement->forceFill([
                'image_url' => 'images/' . $filename,
            ])->save();
        }

        // Gestion des images secondaires
        if (request()->hasFile('images')) {
            foreach (request()->file('images') as $image) {
                $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/images', $filename);

                // Enregistrer chaque image secondaire
                $logement->images()->create(['url' => 'images/' . $filename]);
            }
        }

        // Synchroniser les équipements sélectionnés
        if (isset($validatedData['equipements'])) {
            $logement->equipements()->sync($validatedData['equipements']);
        } else {
            $logement->equipements()->sync([]);
        }

        return redirect()->route('mes-logements.index')->with('success', 'Logement mis à jour avec succès.');
    }


    public function destroyImage($id)
    {
        $image = Image::findOrFail($id);

        Storage::delete('public/' . $image->url);
        $image->delete();

        return redirect()->back()->with('success', 'Image supprimée avec succès.');
    }

    public function reserverLogement(Request $request, $logementId)
    {
        // Validation des dates de réservation
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $logement = Logement::findOrFail($logementId);

        // Convertir les dates en instances de Carbon
        $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
        $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date); // Ajouter un jour à la date de fin

        // Vérifier si les dates sont déjà réservées
        // $existingReservation = Reservations::where('logement_id', $logementId)
        //     ->where('payment_status', 'paid') // S'assurer que la réservation est payée
        //     ->where(function ($query) use ($startDate, $endDate) {
        //         $query->where(function ($query) use ($startDate, $endDate) {
        //             // Vérifier le chevauchement sans inclure le jour où la réservation se termine
        //             $query->where('debut_resa', '<', $endDate) // Commence avant la fin de la nouvelle réservation
        //                 ->where('fin_resa', '>', $startDate); // Se termine après le début de la nouvelle réservation
        //         });
        //     })
        //     ->exists();

        // if ($existingReservation) {
        //     return redirect()->back()->withErrors(['error' => 'Les dates sélectionnées ne sont plus disponibles.']);
        // }


        // Calcul du nombre de nuits
        $nights = $startDate->diffInDays($endDate);

        // Calcul du montant total
        $totalAmount = $logement->price * $nights;

        // Créer une réservation temporaire
        $temporaryReservation = Reservations::create([
            'user_id' => Auth::id(),
            'logement_id' => $logementId,
            'debut_resa' => $startDate,
            'fin_resa' => $endDate,
            'payment_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return view('payment', [
            'logement' => $logement,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'nights' => $nights,
            'totalAmount' => $totalAmount,
            'reservationId' => $temporaryReservation->id,
        ]);
    }





    public function storeAvis(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'comment' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5',
        ]);

        $avis = new Avis();
        $avis->reservations_id = $request->reservation_id;
        $avis->logement_id = Reservations::find($request->reservation_id)->logement_id;
        $avis->user_id = Reservations::find($request->reservation_id)->user_id;
        $avis->rating = $request->rating;
        $avis->comment = $request->comment;
        $avis->save();

        // Envoyer un email de notification au client
        Mail::to($avis->user->email)->send(new AvisPosted($avis));

        // Envoyer un email de notification à l'hôte
        Mail::to($avis->logement->user->email)->send(new AvisPosted($avis, true));

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès.');
    }

    public function updateAvis(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $avis = Avis::findOrFail($id);
        $avis->comment = $request->comment;
        $avis->save();

        return redirect()->back()->with('success', 'Commentaire modifié avec succès.');
    }
}
