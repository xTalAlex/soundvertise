<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SongResource\Pages;
use App\Filament\Resources\SongResource\RelationManagers;
use App\Models\Song;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
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
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Group::make()
                            ->columnSpan(2)
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required(),
                                        Forms\Components\Select::make('genre_id')
                                            ->relationship('genre', 'name'),
                                    ]),
                                Forms\Components\Tabs::make('Tabs')
                                    ->tabs([
                                        Forms\Components\Tabs\Tab::make('Spotify info')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\Section::make()
                                                    ->columns(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('spotify_id')
                                                            ->required(),
                                                        Forms\Components\TextInput::make('spotify_user_id'),
                                                        Forms\Components\TextInput::make('artist_id'),
                                                        Forms\Components\TextInput::make('artist_name'),
                                                        Forms\Components\TextInput::make('artist_genres'),
                                                        Forms\Components\TextInput::make('popularity')
                                                            ->numeric()
                                                            ->required(),
                                                    ])
                                                    ->footerActions([
                                                        Action::make('Open on Spotify')
                                                            ->icon('heroicon-o-link')
                                                            ->url(fn (?Song $record): ?string => $record?->url)
                                                            ->openUrlInNewTab(),
                                                    ]),
                                            ]),
                                        Forms\Components\Tabs\Tab::make('Audio features')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\Fieldset::make()
                                                    ->columns(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('duration_ms'),
                                                        Forms\Components\TextInput::make('time_signature'),
                                                        Forms\Components\TextInput::make('tempo'),
                                                        Forms\Components\TextInput::make('key'),
                                                        Forms\Components\TextInput::make('mode'),
                                                    ]),
                                                Forms\Components\TextInput::make('acousticness'),
                                                Forms\Components\TextInput::make('instrumentalness'),
                                                Forms\Components\TextInput::make('speechiness'),
                                                Forms\Components\TextInput::make('danceability'),
                                                Forms\Components\TextInput::make('energy'),
                                                Forms\Components\TextInput::make('valence'),
                                                Forms\Components\TextInput::make('liveness'),
                                                Forms\Components\TextInput::make('loudness'),
                                            ]),
                                    ]),
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\ViewField::make('embed')
                                            ->hiddenLabel()
                                            ->view('filament.forms.components.song-embed')
                                            ->dehydrated(false),
                                    ])->visibleOn('edit'),
                            ]),
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make()
                                    ->columnSpan(1)
                                    ->schema([
                                        Forms\Components\Select::make('user_id')
                                            ->relationship('user', 'name'),
                                    ]),
                                Forms\Components\Section::make()
                                    ->columnSpan(1)
                                    ->schema([
                                        Forms\Components\Placeholder::make('created_at')
                                            ->content(fn (?Song $record): ?string => $record?->created_at->toFormattedDateString()),
                                        Forms\Components\Placeholder::make('updated_at')
                                            ->content(fn (?Song $record): ?string => $record?->updated_at->toFormattedDateString()),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('user', 'genre'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->url(function (?Song $record): ?string {
                        return $record?->url;
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
            RelationManagers\PairingsRelationManager::class,
            RelationManagers\SubmissionsRelationManager::class,
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
