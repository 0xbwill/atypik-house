<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class GestionEquipements extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Gestion';
    protected static ?string $navigationLabel = 'Gestion équipements';
    protected ?string $heading = 'Gestion des équipements';
    protected ?string $subheading = 'Ajouter, modifier ou supprimer des équipements par type de logement.';

    protected static string $view = 'filament.pages.gestion-equipements';
}
