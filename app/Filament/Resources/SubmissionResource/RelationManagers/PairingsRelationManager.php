<?php

namespace App\Filament\Resources\SubmissionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PairingsRelationManager extends RelationManager
{
    protected static string $relationship = 'pairings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('paired_submission_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('is_match'),
                Forms\Components\TextInput::make('accepted'),
                Forms\Components\TextInput::make('reviewed_at'),
                Forms\Components\TextInput::make('submission_song_added_at'),
                Forms\Components\TextInput::make('submission_song_removed_at'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('paired_submission_id')
            ->columns([
                Tables\Columns\TextColumn::make('paired_submission_id'),
                Tables\Columns\TextColumn::make('is_match'),
                Tables\Columns\TextColumn::make('accepted'),
                Tables\Columns\TextColumn::make('reviewed_at'),
                Tables\Columns\TextColumn::make('submission_song_added_at'),
                Tables\Columns\TextColumn::make('submission_song_removed_at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('New pairing'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
