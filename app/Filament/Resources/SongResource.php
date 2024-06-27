<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SongResource\Pages;
use App\Filament\Resources\SongResource\RelationManagers;
use App\Models\Song;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SongResource extends Resource
{
    protected static ?string $model = Song::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name'),
                Forms\Components\Select::make('genre_id')
                    ->relationship('genre', 'name'),
                Forms\Components\TextInput::make('spotify_id')
                    ->required(),
                Forms\Components\TextInput::make('url')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('artist_id')
                    ->required(),
                Forms\Components\TextInput::make('artist_name')
                    ->required(),
                Forms\Components\Textarea::make('artist_genres')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('duration_ms')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('popularity')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('acousticness')
                    ->numeric(),
                Forms\Components\TextInput::make('instrumentalness')
                    ->numeric(),
                Forms\Components\TextInput::make('speechiness')
                    ->numeric(),
                Forms\Components\TextInput::make('danceability')
                    ->numeric(),
                Forms\Components\TextInput::make('energy')
                    ->numeric(),
                Forms\Components\TextInput::make('valence')
                    ->numeric(),
                Forms\Components\TextInput::make('liveness')
                    ->numeric(),
                Forms\Components\TextInput::make('loudness')
                    ->numeric(),
                Forms\Components\Toggle::make('mode'),
                Forms\Components\TextInput::make('key')
                    ->numeric(),
                Forms\Components\TextInput::make('tempo')
                    ->numeric(),
                Forms\Components\TextInput::make('time_signature')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('genre.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('spotify_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('artist_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('artist_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration_ms')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('popularity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('acousticness')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('instrumentalness')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('speechiness')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('danceability')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('energy')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valence')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('liveness')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loudness')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('mode')
                    ->boolean(),
                Tables\Columns\TextColumn::make('key')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tempo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_signature')
                    ->numeric()
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
            'index' => Pages\ListSongs::route('/'),
            'create' => Pages\CreateSong::route('/create'),
            'edit' => Pages\EditSong::route('/{record}/edit'),
        ];
    }
}
