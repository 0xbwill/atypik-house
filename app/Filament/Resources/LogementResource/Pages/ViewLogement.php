<?php

namespace App\Filament\Resources\LogementResource\Pages;

use App\Filament\Resources\LogementResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLogement extends ViewRecord
{
    protected static string $resource = LogementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
