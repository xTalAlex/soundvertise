<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PairingResource\Pages;
use App\Filament\Resources\PairingResource\RelationManagers;
use App\Models\Pairing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PairingResource extends Resource
{
    protected static ?string $model = Pairing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('submission_id')
                    ->relationship('submission', 'id')
                    ->required(),
                Forms\Components\Select::make('paired_submission_id')
                    ->relationship('pairedSubmission', 'id')
                    ->required(),
                Forms\Components\Toggle::make('accepted'),
                Forms\Components\DateTimePicker::make('answered_at'),
                Forms\Components\DateTimePicker::make('submission_song_added_at'),
                Forms\Components\DateTimePicker::make('submission_song_removed_at'),
                Forms\Components\Toggle::make('is_match'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('submission.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pairedSubmission.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('accepted')
                    ->boolean(),
                Tables\Columns\TextColumn::make('answered_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('submission_song_added_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('submission_song_removed_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_match')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPairings::route('/'),
            'create' => Pages\CreatePairing::route('/create'),
            'edit' => Pages\EditPairing::route('/{record}/edit'),
        ];
    }
}
