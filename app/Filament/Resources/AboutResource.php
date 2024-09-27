<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Filament\Resources\AboutResource\RelationManagers;
use App\Models\About;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;
    protected static ?string $navigationGroup = 'Page à propos';
    // title apge
    protected static ?string $navigationLabel = 'Modifier';
    protected static ?string $slug = 'about';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Section 1')
                ->schema([
                    Forms\Components\TextInput::make('section1_title')
                        ->required(),
                    Forms\Components\TextInput::make('section1_subtitle')
                        ->required(),
                    Forms\Components\Textarea::make('section1_description')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('section1_button_text')
                        ->required(),
                    Forms\Components\TextInput::make('section1_button_link')
                        ->required(),
                    Forms\Components\FileUpload::make('section1_image')
                        ->image()
                        ->required(),
                ])
                ->collapsible() // Optionnel, pour rendre la section repliable si nécessaire
            ,   
            Forms\Components\Section::make('Section 2')
                ->schema([
                    Forms\Components\TextInput::make('section2_title')
                        ->required(),
                    Forms\Components\TextInput::make('section2_subtitle')
                        ->required(),
                    Forms\Components\Textarea::make('section2_description')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('section2_button_text')
                        ->required(),
                    Forms\Components\TextInput::make('section2_button_link')
                        ->required(),
                    Forms\Components\FileUpload::make('section2_image')
                        ->image()
                        ->required(),
                ])
                ->collapsible() // Optionnel, pour rendre la section repliable si nécessaire
            
        ]);
}



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section1_title')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationUrl(): string
    {
        // Vérifiez s'il y a exactement un enregistrement
        $recordCount = About::count();

        if ($recordCount === 1) {
            // Redirige vers l'édition du premier enregistrement si unique
            $record = About::first();
            return route('filament.admin.resources.about.edit', ['record' => $record->id]);
        }

        // Sinon, retournez l'URL de la liste
        return parent::getNavigationUrl();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'view' => Pages\ViewAbout::route('/{record}'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
}
