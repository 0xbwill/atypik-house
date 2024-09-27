<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogementResource\Pages;
use App\Filament\Resources\LogementResource\RelationManagers;
use App\Models\Logement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use App\Models\CategoryLogement;

class LogementResource extends Resource
{
    protected static ?string $model = Logement::class;
    protected static ?string $navigationGroup = 'Modèles';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\Textarea::make('short_description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->label('Category')
                    ->options(CategoryLogement::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('capacity')
                    ->numeric(),
                Forms\Components\TextInput::make('bedrooms')
                    ->numeric(),
                Forms\Components\TextInput::make('bathrooms')
                    ->numeric(),
                Forms\Components\FileUpload::make('image_url')
                    ->disk('public')
                    ->directory('images')
                    ->image(),

                Forms\Components\TextInput::make('pet_allowed'),
                Forms\Components\TextInput::make('smoker_allowed'),
                Forms\Components\TextInput::make('city'),
                Forms\Components\TextInput::make('country'),
                Forms\Components\TextInput::make('street'),
                Forms\Components\TextInput::make('postal_code'),
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->label('Propriétaire')
                    ->getStateUsing(fn($record) => $record->user->name)
                    ->sortable()
                    ->url(fn($record) => route('filament.admin.resources.users.view', $record->user_id)),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_url'),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category_id')
                    ->label('Categorie')
                    ->getStateUsing(fn($record) => $record->category->name)
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLogements::route('/'),
            'create' => Pages\CreateLogement::route('/create'),
            'view' => Pages\ViewLogement::route('/{record}'),
            'edit' => Pages\EditLogement::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
