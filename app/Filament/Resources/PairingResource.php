<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PairingResource\Pages;
use App\Models\Pairing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PairingResource extends Resource
{
    protected static ?string $model = Pairing::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('submission_id')
                                    ->relationship('submission', 'id')
                                    ->required(),
                                Forms\Components\Toggle::make('accepted'),
                                Forms\Components\DateTimePicker::make('answered_at'),
                                Forms\Components\DateTimePicker::make('submission_song_added_at'),
                                Forms\Components\DateTimePicker::make('submission_song_removed_at'),
                            ])->columnSpan(1),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('paired_submission_id')
                                    ->relationship('pairedSubmission', 'id')
                                    ->required(),
                                Forms\Components\Toggle::make('is_match'),
                            ])->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(
                'submission.user',
                'submission.song',
                'submission.playlist',
                'pairedSubmission.user',
                'pairedSubmission.song',
                'pairedSubmission.playlist')
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('submission.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('submission.user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('submission.song.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('submission.playlist.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('accepted')
                    ->boolean(),
                Tables\Columns\TextColumn::make('answered_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pairedSubmission.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pairedSubmission.user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pairedSubmission.song.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pairedSubmission.playlist.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_match')
                    ->boolean(),
                Tables\Columns\TextColumn::make('submission_song_added_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('submission_song_removed_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePairing::route('/'),
        ];
    }
}
