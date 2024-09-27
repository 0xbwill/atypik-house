<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class HostRequest extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Gestion';
    protected static ?string $navigationLabel = 'Demandes d\'hôtes';
    protected ?string $heading = 'Gestion des demandes d\'hôtes';
    protected ?string $subheading = 'Accepter ou refuser les demandes d\'hôtes.';

    protected static string $view = 'filament.pages.host-request';
}
