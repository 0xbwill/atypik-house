<?php

namespace App\Console\Commands;

use App\Models\Logement;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'generate:sitemap';
    protected $description = 'Generate the sitemap.xml file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Ajouter les URLs manuellement avec leur priorité et fréquence de changement
        $urls = [
            ['loc' => '/', 'priority' => 1.0, 'lastmod' => '2024-08-26T12:02:31+00:00', 'freq' => Url::CHANGE_FREQUENCY_DAILY],
            ['loc' => '/about', 'priority' => 0.8, 'lastmod' => '2024-08-26T12:02:31+00:00', 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['loc' => '/logements', 'priority' => 0.7, 'lastmod' => '2024-08-26T12:02:31+00:00', 'freq' => Url::CHANGE_FREQUENCY_WEEKLY],
            ['loc' => '/login', 'priority' => 0.8, 'lastmod' => '2024-08-26T12:02:31+00:00', 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['loc' => '/register', 'priority' => 0.8, 'lastmod' => '2024-08-26T12:02:31+00:00', 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['loc' => '/contact', 'priority' => 0.8, 'lastmod' => '2024-08-26T12:02:31+00:00', 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['loc' => '/legal', 'priority' => 0.8, 'lastmod' => '2024-08-26T12:02:31+00:00', 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['loc' => '/guide', 'priority' => 0.8, 'lastmod' => '2024-08-26T12:02:31+00:00', 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
        ];

        // Ajouter les logements dynamiquement
        $logements = Logement::all(); // Assurez-vous d'importer le modèle Logement en haut du fichier
        foreach ($logements as $logement) {
            $urls[] = [
                'loc' => "/logement/{$logement->slug}",
                'priority' => 0.8,
                'lastmod' => '2024-08-26T12:02:31+00:00',
                'freq' => Url::CHANGE_FREQUENCY_WEEKLY,
            ];
        }

        // Ajouter les profils dynamiquement
        $profils = ['ms-brandi-rowe-sr', 'miss-kyra-strosin', 'gaetano-anderson', 'dax-considine-i', 'dsp-user', 'mr-arthur-hills', 'aliya-conn', 'marina-fahey', 'herminio-greenholt', 'deborah-carter-jr', 'benjamin', 'dr-kira-dietrich', 'anahi-reichert', 'william', 'prof-daryl-upton', 'meta-reichert', 'shaun-macejkovic-iv', 'nicolas', 'mabel-crona-v', 'robb-medhurst', 'patrick', 'mr-jaeden-waelchi-sr', 'dsp-hote'];
        foreach ($profils as $slug) {
            $urls[] = [
                'loc' => "/profil/{$slug}",
                'priority' => 0.8,
                'lastmod' => '2024-08-26T12:02:31+00:00',
                'freq' => Url::CHANGE_FREQUENCY_MONTHLY,
            ];
        }

        // Ajouter toutes les URLs au sitemap
        foreach ($urls as $url) {
            $sitemap->add(
                Url::create($url['loc'])
                    ->setPriority($url['priority'])
                    ->setChangeFrequency($url['freq'])
                    ->setLastModificationDate(new \DateTime($url['lastmod']))
            );
        }

        // Enregistrer le fichier sitemap.xml
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap has been generated.');
    }
}
