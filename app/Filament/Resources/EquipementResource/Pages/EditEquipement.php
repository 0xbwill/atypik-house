<?php

namespace App\Filament\Resources\EquipementResource\Pages;

use App\Filament\Resources\EquipementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipement extends EditRecord
{
    protected static string $resource = EquipementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
