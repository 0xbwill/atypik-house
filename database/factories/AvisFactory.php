<?php

namespace Database\Factories;

use App\Models\Avis;
use App\Models\Reservations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvisFactory extends Factory
{
    protected $model = Avis::class;

    public function definition()
    {
        $now = now();
        $reservation_id = Reservations::where('fin_resa', '<', $now)->inRandomOrder()->first()->id;
        $reservation = Reservations::findOrFail($reservation_id);
        $logement = $reservation->logement_id;
        $user = $reservation->user_id;

        // Distribution pondérée des notes (plus de chances d'avoir 4 ou 5)
        $rating = $this->getWeightedRating(); // Fonction pour générer la note pondérée
        $comments = $this->getComments();

        // Sélectionner un commentaire basé sur la note
        $comment = $comments[$rating][array_rand($comments[$rating])];

        return [
            'reservations_id' => $reservation_id,
            'logement_id' => $logement,
            'user_id' => $user,
            'rating' => $rating,
            'comment' => $comment, 
        ];
    }

    protected function getComments()
    {
        return [
            5 => [
                'Séjour incroyable, tout était parfait !',
                'Expérience inoubliable, le logement était superbe.',
                'Hôte très accueillant et logement impeccable. Nous reviendrons !',
                'Le logement était encore mieux que sur les photos, vraiment une expérience unique.',
                'Tout était à la hauteur de nos attentes et même au-delà, un grand merci !',
                'Un séjour mémorable dans un endroit magnifique, tout était parfait.',
                'Propreté impeccable, confort optimal et localisation idéale, rien à redire.',
                'Nous avons adoré chaque minute passée dans ce logement. Hôte charmant et logement fabuleux.',
                'Logement moderne et super bien équipé, parfait pour un séjour détente !',
                'Incroyable, tout était pensé dans les moindres détails pour un séjour parfait !'
            ],
            4 => [
                'Très bon séjour, quelques détails à améliorer mais dans l’ensemble, c’était excellent.',
                'Le logement était très confortable, mais il pourrait être encore mieux avec quelques améliorations.',
                'Bon rapport qualité-prix, je recommande.',
                'Nous avons passé un excellent moment, juste quelques petits ajustements à faire.',
                'Le logement était agréable mais un peu bruyant à certains moments.',
                'Bon séjour, quelques problèmes mineurs mais l’hôte a été très réactif.',
                'Très bien situé et le logement était conforme à la description.',
                'Logement chaleureux et bien équipé, même si quelques éléments pourraient être améliorés.',
                'Expérience agréable, mais la literie pourrait être plus confortable.',
                'L’endroit est charmant, cependant la propreté pourrait être améliorée.'
            ],
            3 => [
                'Le séjour était correct, mais il y avait quelques problèmes de propreté.',
                'L’emplacement était idéal, mais le logement pourrait être mieux entretenu.',
                'C’était un bon séjour, mais quelques améliorations sont nécessaires.',
                'Logement assez confortable, mais plusieurs petits défauts ont rendu le séjour moins agréable.',
                'La communication avec l’hôte était moyenne et le logement avait quelques défauts.',
                'Le logement était bien situé, mais il manquait certains équipements de base.',
                'Séjour correct mais le rapport qualité-prix n’était pas au rendez-vous.',
                'Logement pratique mais un peu vieillot, quelques rénovations ne feraient pas de mal.',
                'C’était bien, mais la propreté laissait à désirer.',
                'Le logement pourrait être amélioré, notamment au niveau des équipements.'
            ],
            2 => [
                'Décevant. Le logement n’était pas à la hauteur de nos attentes.',
                'Quelques problèmes avec les équipements, séjour moyen.',
                'Le logement avait besoin de réparations, ce qui a gâché notre expérience.',
                'Pas à la hauteur de la description, nous avons été un peu déçus.',
                'Hôte aimable mais le logement avait beaucoup de problèmes, notamment d’entretien.',
                'Séjour passable, la propreté et les équipements étaient loin d’être satisfaisants.',
                'Trop de nuisances sonores et le logement était mal isolé.',
                'L’endroit avait du potentiel, mais mal entretenu, ce qui a rendu le séjour désagréable.',
                'Le logement est bien situé, mais il manque cruellement de confort.',
                'Expérience globalement décevante, des problèmes récurrents pendant notre séjour.'
            ],
            1 => [
                'Très mauvaise expérience, je ne recommande pas ce logement.',
                'Le logement était sale et mal entretenu, très décevant.',
                'Horrible séjour, nous avons dû partir plus tôt que prévu à cause des conditions du logement.',
                'Le pire séjour que nous ayons eu, je déconseille vivement ce logement.',
                'Le logement ne correspondait absolument pas aux photos, une véritable arnaque.',
                'Hôte très désagréable et logement en mauvais état, une expérience désastreuse.',
                'C’était une catastrophe, le logement était insalubre.',
                'Je n’ai jamais vu un logement aussi sale, nous avons dû nettoyer nous-mêmes.',
                'Le chauffage ne fonctionnait pas, et il faisait très froid dans le logement.',
                'Très mauvaise expérience, je déconseille vivement cet endroit.'
            ]
        ];
    }

    protected function getWeightedRating()
    {
        // Probabilités pondérées pour générer des avis 4 et 5 étoiles plus souvent
        $ratings = [
            5, 5, 5, 5, 5, 5, 4, 4, 4, 4, 4 // Plus de 4 et 5 étoiles
        ];

        return $this->faker->randomElement($ratings);
    }
}
