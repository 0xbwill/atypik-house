<?php

namespace App\Filament\Resources\CategoryLogementResource\Pages;

use App\Filament\Resources\CategoryLogementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryLogements extends ListRecords
{
    protected static string $resource = CategoryLogementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
