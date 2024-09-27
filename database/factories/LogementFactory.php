<?php

namespace Database\Factories;

use App\Models\Logement;
use App\Models\CategoryLogement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // Importez Str pour générer le slug
use App\Models\Image;


class LogementFactory extends Factory
{
    protected $model = Logement::class;

    public function definition()
    {
        // Tableau des logements disponibles
        $logementData = $this->getLogementsData();

        // Initialiser l'index si ce n'est pas encore fait
        if (!isset(self::$logementIndex)) {
            self::$logementIndex = 0;
        }

        // Obtenir le titre et les données correspondantes
        $titles = array_keys($logementData);

        // Vérifier si l'index dépasse le nombre d'éléments dans le tableau
        if (self::$logementIndex >= count($titles)) {
            self::$logementIndex = 0; // Réinitialiser ou lancer une exception selon vos besoins
        }

        $title = $titles[self::$logementIndex];
        $data = $logementData[$title];

        // Incrémenter l'index pour le prochain appel
        self::$logementIndex++;

        // Générer la ville, le code postal et la rue
        $location = $this->generateCityPostalCodeAndStreet();

        return [
            'title' => $title,
            'slug' => Str::slug($title), // Générer le slug basé sur le titre
            'short_description' => $data['short_description'],
            'description' => $data['description'],
            'price' => $this->faker->numberBetween(80, 800),
            'capacity' => $this->faker->numberBetween(2, 20),
            'bedrooms' => $this->faker->numberBetween(1, 10),
            'bathrooms' => $this->faker->numberBetween(1, 5),
            'pet_allowed' => $this->faker->boolean,
            'smoker_allowed' => $this->faker->boolean,
            'city' => $location['city'],
            'country' => "France",
            'street' => $location['street'],
            'postal_code' => $location['postal_code'],
            'user_id' => User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'hôte']);
            })->inRandomOrder()->first()->id,
            'category_id' => CategoryLogement::inRandomOrder()->first()->id,
            'image_url' => $data['image_url'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Déclaration de la propriété statique pour suivre l'index
    protected static $logementIndex;


    protected function getLogementsData()
    {
        return [
            'L’Oasis Écologique des Montagnes : Sérénité & Authenticité' => [
                'short_description' => 'Venez vous détendre dans cette charmante cabane perchée à 7,5 mètres de hauteur, en pleine nature.',
                'description' => 'Venez vous détendre dans cette charmante cabane de 25m², perchée à 7,5 mètres de hauteur. Accessible par un élégant escalier en colimaçon, elle vous offre une vue panoramique sur la forêt environnante. Profitez de la tranquillité et des sons apaisants de la nature tout autour. Vous pourrez prendre votre petit déjeuner sur la terrasse couverte et admirer le ciel étoilé le soir venu.',
                'image_url' => 'https://www.introuvable.com/application/uploads/idev_place/2957/thumbs/thumb_1200_576155dfb3ff3.jpg',
                'secondary_images' => [
                    'https://www.introuvable.com/application/uploads/idev_place/2957/thumbs/thumb_1200_5761563a9685e.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/2957/thumbs/thumb_1200_576155a4542f8.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/2957/thumbs/thumb_1200_5761560d78fa2.jpg',
                ]
            ],
            'Cabane perchée dans les arbres, immersion en plein air' => [
                'short_description' => 'Découvrez cette cabane luxueuse perchée à 8 mètres de hauteur avec une vue imprenable.',
                'description' => 'Nichée à 8 mètres au-dessus du sol, cette cabane offre une vue spectaculaire sur les montagnes environnantes. Spacieuse et élégamment aménagée, elle peut accueillir jusqu’à 10 personnes. Idéale pour une escapade luxueuse en pleine nature, vous bénéficierez de tout le confort moderne tout en étant entouré de tranquillité.',
                'image_url' => 'https://www.introuvable.com/application/uploads/idev_place/2770/thumbs/thumb_1200_5751b1c726643.jpg',
                'secondary_images' => [
                    'https://space2scan.com/wp-content/uploads/2020/12/espaceatypique-1400.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/2859/thumbs/thumb_1200_575e81b4918c0.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/1705/thumbs/thumb_1200_58dcd85e2dd51.jpg',
                ]
            ],
            'Cabane dans les arbres, vue panoramique, Chalais' => [
                'short_description' => 'Séjournez dans cette cabane dans les arbres avec vue panoramique, pour une expérience unique.',
                'description' => 'Perchée dans les arbres, cette cabane offre une vue panoramique époustouflante sur le paysage environnant. Parfaite pour une escapade reposante, elle combine confort et immersion totale dans la nature. Détendez-vous sur la terrasse avec vue ou profitez d’une nuit étoilée au milieu des cimes.',
                'image_url' => 'https://www.introuvable.com/application/uploads/idev_place/2858/thumbs/thumb_1200_575e7a3c7b22f.jpg',
                'secondary_images' => [
                    'https://space2scan.com/wp-content/uploads/2020/12/espaceatypique-1400.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/159/thumbs/thumb_1200_5a93dbdbe7bd8.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/159/thumbs/thumb_1200_5a93dbcbddbdc.jpg',
                ]
            ],
            'Cabane Mont-Blanc, Cabane de luxe avec jacuzzi et sauna privés' => [
                'short_description' => 'Vivez le luxe ultime dans cette cabane au Mont-Blanc avec jacuzzi et sauna privés.',
                'description' => 'Offrez-vous une expérience de luxe dans cette cabane au Mont-Blanc. Équipée d’un jacuzzi et d’un sauna privés, cette retraite montagneuse est le choix parfait pour une escapade relaxante. Avec une vue imprenable sur les sommets enneigés et tout le confort moderne, cette cabane est un véritable havre de paix pour les amateurs de nature et de bien-être.',
                'image_url' => 'https://www.introuvable.com/application/uploads/idev_place/3288/thumbs/thumb_1200_5940451f5ad3c.jpg',
                'secondary_images' => [
                    'https://www.introuvable.com/application/uploads/idev_place/3289/thumbs/thumb_1200_594045862e285.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/3287/thumbs/thumb_1200_594044e36d2f3.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/3289/thumbs/thumb_1200_594045552631a.jpg',
                ]
            ],
            'Cabane insolite pour deux avec spa et terrasse avec vue, Clairac' => [
                'short_description' => 'Laissez-vous envahir par l’esprit de cette cabane représenté par son décor soigneusement pensé et savourez l’intimité de l’espace salon pour vous relaxer',
                'description' => 'La cabane Vénitienne est résolument empreinte d’un esprit baroque qui vous transportera comme sur un air d’opéra. L’esprit Vénitien de cette cabane perchée vous permet de profiter d’une alcôve d’un grand confort où vous pourrez vous reposer et vous détendre.',
                'image_url' => 'https://www.introuvable.com/application/uploads/idev_place/1703/thumbs/thumb_1200_58dcd7abcafc2.jpg',
                'secondary_images' => [
                    'https://www.introuvable.com/application/uploads/idev_place/1703/thumbs/thumb_1200_58dcd7b649715.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/1703/thumbs/thumb_1200_58dcd7becc63b.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/1703/thumbs/thumb_1200_58dcd7d99332c.jpg',
                ]
            ],
            'La Cabane Écolo en Pleine Forêt : Havre de Paix, Nature et Sérénité' => [
                'short_description' => 'Le Pod est un hébergement connu, qui est arrivé en France que très récemment',
                'description' => "Originaire du Royaume Uni, cet hébergement simple en bois en forme de demi-cercle, se confond avec la nature. L'intérieur d'un Pod est confortable mais épuré et de ce fait rend ce petit logement de 10 m2 , original, insolite et très recherché. Le Pod est dans l'air du temps et propose de suivre la direction du tourisme naturel, un retour à l'essentiel.",
                'image_url' => 'https://www.introuvable.com/application/uploads/idev_place/2218/thumbs/thumb_1200_566ac46872770.jpg',
                'secondary_images' => [
                    'https://www.introuvable.com/application/uploads/idev_place/2218/thumbs/thumb_1200_566ac47270954.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/2218/thumbs/thumb_1200_566ac47f2c5f6.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/2218/thumbs/thumb_1200_566ac47668155.jpg',
                ]
            ],
            'Yourte Mongole Authentique avec Vue Imprenable, Auvergne' => [
                'short_description' => 'Séjournez dans une yourte mongole authentique avec une vue magnifique sur les montagnes d\'Auvergne.',
                'description' => 'Découvrez le charme d\'une yourte mongole traditionnelle dans un cadre naturel époustouflant. Située au cœur des montagnes d\'Auvergne, cette yourte de 35m² est idéale pour une immersion totale dans la nature. Avec ses matériaux écologiques et son confort moderne, elle est parfaite pour un séjour paisible et ressourçant.',
                'image_url' => 'https://www.introuvable.com/application/uploads/idev_place/12127/thumbs/thumb_1200_5fc4e132e4a93.jpg',
                'secondary_images' => [
                    'https://www.introuvable.com/application/uploads/idev_place/12127/thumbs/thumb_1200_5fc4e15dc24cb.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/12127/thumbs/thumb_1200_5fc4e16557d0e.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/12127/thumbs/thumb_1200_5fc4e1676bb5a.jpg',
                ]
            ],
            'Tipi Indien Traditionnel, Immersion Nature à Fontainebleau' => [
                'short_description' => 'Vivez une expérience unique dans un tipi indien au cœur de la forêt de Fontainebleau.',
                'description' => 'Plongez-vous dans la culture amérindienne en séjournant dans ce tipi authentique. Situé au cœur de la forêt de Fontainebleau, cet hébergement insolite vous permet de vous reconnecter avec la nature tout en profitant de tout le confort moderne. Idéal pour une retraite spirituelle ou une escapade romantique.',
                'image_url' => 'https://www.introuvable.com/application/uploads/idev_place/28383/thumbs/thumb_1200_65acb8c428f77.jpg',
                'secondary_images' => [
                    'https://www.introuvable.com/application/uploads/idev_place/28383/thumbs/thumb_1200_65acb85e59ff8.jpeg',
                    'https://www.introuvable.com/application/uploads/idev_place/28383/thumbs/thumb_1200_65acb862e38f2.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/28383/thumbs/thumb_1200_65acb8a5679e2.jpg',
                ]
            ],
            'Dôme Géodésique Écologique avec Vue sur la Mer, Bretagne' => [
                'short_description' => 'Séjournez dans un dôme géodésique avec vue panoramique sur la mer.',
                'description' => 'Venez découvrir le confort et la modernité d\'un dôme géodésique écologique en Bretagne. Avec une vue imprenable sur l\'océan Atlantique, cet hébergement atypique vous offre un cadre unique pour vous détendre et profiter des paysages côtiers. Totalement intégré à son environnement, ce dôme est idéal pour les amateurs de nature et d\'écotourisme.',
                'image_url' => 'https://www.introuvable.com/application/uploads/idev_place/29335/thumbs/thumb_1200_6649ca4366d81.jpg',
                'secondary_images' => [
                    'https://www.introuvable.com/application/uploads/idev_place/29335/thumbs/thumb_1200_6649ca4e16cb6.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/29335/thumbs/thumb_1200_6649ca2777f02.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/29083/thumbs/thumb_1200_662a745bbf91e.jpg',
                ]
            ],
            'Roulotte en Pleine Nature, Provence' => [
                'short_description' => 'Profitez d\'une roulotte traditionnelle au cœur des champs de lavande en Provence.',
                'description' => 'Immergez-vous dans l\'esprit nomade avec cette roulotte tzigane traditionnelle, située au milieu des champs de lavande en Provence. Avec son intérieur chaleureux et rustique, elle est l\'endroit parfait pour un séjour romantique ou en famille. Offrant une vue sublime sur les collines environnantes, elle promet une expérience authentique et dépaysante.',
                'image_url' => 'https://www.introuvable.com/application/uploads/idev_place/2219/thumbs/thumb_1200_566ac76046086.jpg',
                'secondary_images' => [
                    'https://www.introuvable.com/application/uploads/idev_place/2219/thumbs/thumb_1200_566ac76520ce3.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/2219/thumbs/thumb_1200_566ac753bd44d.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/2219/thumbs/thumb_1200_566ac77010611.jpg',
                ]
            ],
            'Maison Flottante Écologique, Lac de Biscarrosse' => [
                'short_description' => 'Vivez l\'expérience unique de séjourner dans une maison flottante sur le lac de Biscarrosse.',
                'description' => 'Cette maison flottante écologique, ancrée au milieu du lac de Biscarrosse, vous offre une expérience hors du commun. Totalement équipée et respectueuse de l\'environnement, elle vous permet de profiter de la tranquillité de l\'eau et de vous ressourcer dans un cadre naturel exceptionnel. Idéal pour les amoureux de la nature et du calme.',
                'image_url' => 'https://www.introuvable.com/application/uploads/idev_place/14291/thumbs/thumb_1200_607da8c801def.jpg',
                'secondary_images' => [
                    'https://www.introuvable.com/application/uploads/idev_place/14291/thumbs/thumb_1200_607da819ab0b2.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/10064/thumbs/thumb_1200_5f1b051a031fe.jpg',
                    'https://www.introuvable.com/application/uploads/idev_place/10064/thumbs/thumb_1200_5f1b0450b6e12.jpg',
                ]
            ],
        ];
    }


    public function configure()
    {
        return $this->afterCreating(function (Logement $logement) {
            $logementData = $this->getLogementsData();
            $data = $logementData[$logement->title];

            // Ajouter les images secondaires
            foreach ($data['secondary_images'] as $image) {
                Image::create([
                    'logement_id' => $logement->id,
                    'url' => $image
                ]);
            }
        });
    }


    protected function generateCityPostalCodeAndStreet()
    {
        $locations = [
            'Paris' => [
                'postal_code' => '75000',
                'streets' => [
                    'Avenue des Champs-Élysées',
                    'Rue de Rivoli',
                    'Boulevard Saint-Germain',
                    'Rue du Faubourg Saint-Honoré',
                    'Rue de la Paix'
                ]
            ],
            'Lyon' => [
                'postal_code' => '69000',
                'streets' => [
                    'Rue de la République',
                    'Avenue Jean Jaurès',
                    'Rue Victor Hugo',
                    'Boulevard des Belges',
                    'Rue Mercière'
                ]
            ],
            'Marseille' => [
                'postal_code' => '13000',
                'streets' => [
                    'La Canebière',
                    'Rue Saint-Ferréol',
                    'Boulevard Longchamp',
                    'Avenue du Prado',
                    'Rue de Rome'
                ]
            ],
            'Toulouse' => [
                'postal_code' => '31000',
                'streets' => [
                    'Boulevard de Strasbourg',
                    'Rue d’Alsace-Lorraine',
                    'Avenue de Lyon',
                    'Rue du Taur',
                    'Place du Capitole'
                ]
            ],
            'Nice' => [
                'postal_code' => '06000',
                'streets' => [
                    'Promenade des Anglais',
                    'Avenue Jean Médecin',
                    'Rue de France',
                    'Boulevard Victor Hugo',
                    'Rue Masséna'
                ]
            ],
            'Bordeaux' => [
                'postal_code' => '33000',
                'streets' => [
                    'Cours de l’Intendance',
                    'Rue Sainte-Catherine',
                    'Boulevard Alfred-Daney',
                    'Place des Quinconces',
                    'Rue du Palais-Gallien'
                ]
            ],
            'Nantes' => [
                'postal_code' => '44000',
                'streets' => [
                    'Rue Crébillon',
                    'Boulevard des 50 Otages',
                    'Rue de Strasbourg',
                    'Cours Cambronne',
                    'Quai de la Fosse'
                ]
            ],
            'Strasbourg' => [
                'postal_code' => '67000',
                'streets' => [
                    'Rue des Grandes Arcades',
                    'Place Kléber',
                    'Avenue de la Liberté',
                    'Rue du Vieux-Marché-aux-Poissons',
                    'Quai des Bateliers'
                ]
            ],
            'Lille' => [
                'postal_code' => '59000',
                'streets' => [
                    'Rue de Béthune',
                    'Boulevard de la Liberté',
                    'Rue Faidherbe',
                    'Rue de la Monnaie',
                    'Rue Gambetta'
                ]
            ],
            'Rennes' => [
                'postal_code' => '35000',
                'streets' => [
                    'Rue Saint-Malo',
                    'Rue d’Antrain',
                    'Rue Le Bastard',
                    'Place Sainte-Anne',
                    'Rue de la Visitation'
                ]
            ]
        ];


        // Choisir une ville aléatoirement
        $city = $this->faker->randomElement(array_keys($locations));
        $postalCode = $locations[$city]['postal_code'];
        $street = $this->faker->randomElement($locations[$city]['streets']);

        return [
            'city' => $city,
            'postal_code' => $postalCode,
            'street' => $street
        ];
    }
}
