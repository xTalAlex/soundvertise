<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SongResource\Pages;
use App\Models\Song;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SongResource extends Resource
{
    protected static ?string $model = Song::class;

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';

    protected static ?string $navigationGroup = 'Music';

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
                Forms\Components\DateTimePicker::make('updated_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('user', 'genre'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->url(function (Song $record): string {
                        return $record->url;
                    })
                    ->openUrlInNewTab()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('spotify_id')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('genre.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('popularity')
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
