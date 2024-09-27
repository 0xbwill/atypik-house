<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationsResource\Pages;
use App\Filament\Resources\ReservationsResource\RelationManagers;
use App\Models\Reservations;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationsResource extends Resource
{
    protected static ?string $model = Reservations::class;
    protected static ?string $navigationGroup = 'Modèles';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('debut_resa')
                ->label('Date de réservation')->required(),
            Forms\Components\DatePicker::make('fin_resa')
                ->label('Date de fin de reservation')
                ->required(),
            Forms\Components\Select::make('user_id')
                ->label('Client')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),
            Forms\Components\Select::make('payment_status')
                ->label('Statut de paiement')
                ->options([
                    'pending' => 'En attente',
                    'paid' => 'Payé',
                    'canceled' => 'Annulé',
                ])
                ->default('pending')
                ->required(),
            Forms\Components\Placeholder::make('user_phone')
                ->label('Numéro de téléphone')
                ->content(fn($record) => $record->user->phone ?? 'Non disponible'),
            Forms\Components\Placeholder::make('user_email')
                ->label('Email')
                ->content(fn($record) => $record->user->email ?? 'Non disponible'),
            Forms\Components\DatePicker::make('payment_date')
                ->label('Date de paiement')->nullable(),
            Forms\Components\TextInput::make('total_amount')
                ->label('Montant total')->nullable()->numeric(),
            Forms\Components\TextInput::make('stripe_transaction_id')
                ->label('Transaction Stripe')->nullable(),
            Forms\Components\TextInput::make('stripe_token')->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('debut_resa')
                    ->date()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('fin_resa')
                    ->date()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Client')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('logement_id')
                    ->label('Logement')
                    ->url(fn($record) => "/admin/logements/{$record->logement_id}")
                    ->formatStateUsing(fn($state) => 'Voir le logement')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('debut_resa')
                    ->form([
                        Forms\Components\DatePicker::make('debut_resa_from')
                            ->label('Début après'),
                        Forms\Components\DatePicker::make('debut_resa_to')
                            ->label('Début avant'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['debut_resa_from'], fn($query, $date) => $query->where('debut_resa', '>=', $date))
                            ->when($data['debut_resa_to'], fn($query, $date) => $query->where('debut_resa', '<=', $date));
                    }),
                Tables\Filters\Filter::make('fin_resa')
                    ->form([
                        Forms\Components\DatePicker::make('fin_resa_from')
                            ->label('Fin après'),
                        Forms\Components\DatePicker::make('fin_resa_to')
                            ->label('Fin avant'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['fin_resa_from'], fn($query, $date) => $query->where('fin_resa', '>=', $date))
                            ->when($data['fin_resa_to'], fn($query, $date) => $query->where('fin_resa', '<=', $date));
                    }),
                Tables\Filters\Filter::make('user_email')
                    ->label('Filtrer par Email')
                    ->form([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Email de l\'utilisateur'),
                    ])
                    ->query(fn(Builder $query, array $data): Builder => $query
                        ->when($data['email'], fn($query, $email) => $query->whereHas('user', fn($q) => $q->where('email', 'like', "%{$email}%")))),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListReservations::route('/'),
            'view' => Pages\ShowReservation::route('/{record}'),
            'create' => Pages\CreateReservations::route('/create'),
            'edit' => Pages\EditReservations::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
