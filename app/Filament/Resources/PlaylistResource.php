<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaylistResource\Pages;
use App\Filament\Resources\PlaylistResource\RelationManagers;
use App\Models\Playlist;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PlaylistResource extends Resource
{
    protected static ?string $model = Playlist::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

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
                                Forms\Components\Section::make('Spotify info')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('spotify_id')
                                            ->required(),
                                        Forms\Components\TextInput::make('spotify_user_id')
                                            ->required(),
                                        Forms\Components\TextInput::make('followers_total')
                                            ->required()
                                            ->numeric()
                                            ->default(0),
                                        Forms\Components\TextInput::make('tracks_total')
                                            ->required()
                                            ->numeric()
                                            ->default(0),
                                        Forms\Components\Toggle::make('collaborative')
                                            ->required(),
                                        Forms\Components\Textarea::make('description')
                                            ->columnSpanFull(),
                                    ])
                                    ->footerActions([
                                        Action::make('Open on Spotify')
                                            ->icon('heroicon-o-link')
                                            ->url(fn (?Playlist $record): ?string => $record?->url)
                                            ->openUrlInNewTab(),
                                    ]),
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\ViewField::make('embed')
                                            ->hiddenLabel()
                                            ->view('filament.forms.components.playlist-embed')
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
                                        SpatieMediaLibraryFileUpload::make('screenshots')
                                            ->collection('screenshots')
                                            ->multiple()
                                            ->downloadable(),
                                        Forms\Components\TextInput::make('monthly_listeners')
                                            ->numeric(),
                                        Forms\Components\Toggle::make('approved')
                                            ->required(),
                                        Forms\Components\DateTimePicker::make('reviewed_at'),
                                    ]),
                                Forms\Components\Section::make()
                                    ->columnSpan(1)
                                    ->schema([
                                        Forms\Components\Placeholder::make('created_at')
                                            ->content(fn (?Playlist $record): ?string => $record?->created_at->toFormattedDateString()),
                                        Forms\Components\Placeholder::make('updated_at')
                                            ->content(fn (?Playlist $record): ?string => $record?->updated_at->toFormattedDateString()),
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
                    ->url(function (?Playlist $record): ?string {
                        return $record?->url;
                    })
                    ->openUrlInNewTab()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('genre.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('spotify_id')
                    ->searchable(['spotify_id', 'spotify_user_id'])
                    ->toggleable()
                    ->toggledHiddenByDefault('true'),
                Tables\Columns\IconColumn::make('approved')
                    ->boolean(),
                Tables\Columns\IconColumn::make('collaborative')
                    ->boolean()
                    ->toggleable()
                    ->toggledHiddenByDefault('true')
                    ->columnSpanFull(),
                Tables\Columns\TextColumn::make('followers_total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tracks_total')
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
            'index' => Pages\ListPlaylists::route('/'),
            'create' => Pages\CreatePlaylist::route('/create'),
            'edit' => Pages\EditPlaylist::route('/{record}/edit'),
        ];
    }
}
