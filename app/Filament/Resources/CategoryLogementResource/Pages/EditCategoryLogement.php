<?php

namespace App\Filament\Resources\CategoryLogementResource\Pages;

use App\Filament\Resources\CategoryLogementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryLogement extends EditRecord
{
    protected static string $resource = CategoryLogementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
