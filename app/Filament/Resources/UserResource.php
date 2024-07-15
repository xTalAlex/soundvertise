<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->columnSpan(2)
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required(),
                                        Forms\Components\Group::make()
                                            ->columns(2)
                                            ->columnSpan(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('email')
                                                    ->email()
                                                    ->required(),
                                                Forms\Components\DateTimePicker::make('email_verified_at'),
                                            ]),
                                    ]),
                                Forms\Components\Section::make('Spotify Info')
                                    ->columns(2)
                                    ->headerActions([
                                        Action::make('View')
                                            ->icon('heroicon-o-link')
                                            ->url(fn (?User $record): ?string => $record->url)
                                            ->openUrlInNewTab(),
                                    ])
                                    ->footerActions([
                                        Action::make('test')
                                            ->action(function () {
                                                // ...
                                            }),
                                    ])
                                    ->schema([
                                        Forms\Components\Placeholder::make('sptify_avatar')
                                            ->content(
                                                function (Get $get): ?HtmlString {
                                                    return new HtmlString('<img class="rounded-full size-32" src="'.$get('spotify_avatar').'" />');
                                                }),
                                        Forms\Components\Placeholder::make('spotify_id')
                                            ->content(fn (?User $record): ?string => $record?->spotify_id),
                                        Forms\Components\Placeholder::make('spotify_playlists_total')
                                            ->content(fn (?User $record): ?string => $record?->spotify_playlists_total),
                                        Forms\Components\Placeholder::make('spotify_filtered_playlists_total')
                                            ->content(fn (?User $record): ?string => $record?->spotify_filtered_playlists_total),
                                        // Forms\Components\Placeholder::make('spotify_access_token')
                                        //     ->content(fn (?User $record): ?string => $record?->spotify_access_token),
                                        // Forms\Components\Placeholder::make('spotify_refresh_token')
                                        //     ->content(fn (?User $record): ?string => $record?->spotify_refresh_token),
                                        Forms\Components\Placeholder::make('spotify_token_expiration')
                                            ->content(fn (?User $record): ?string => $record?->spotify_token_expiration),
                                    ]),
                            ]),
                        Forms\Components\Grid::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\Section::make('Avatar')
                                    ->schema([
                                        Forms\Components\FileUpload::make('profile_photo_path')
                                            ->hiddenLabel()
                                            ->directory('profile-photos')
                                            ->disabled(),
                                    ]),
                                Forms\Components\Section::make('')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_admin')
                                            ->required(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo_url')
                    ->label('Avatar')
                    ->circular(),
                Tables\Columns\TextColumn::make('spotify_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->icon(fn (?string $state = null): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-clock')
                    ->color(fn (?string $state = null): string => $state ? 'success' : 'gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean()
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\PlaylistsRelationManager::class,
            RelationManagers\SongsRelationManager::class,
            RelationManagers\SubmissionsRelationManager::class,
            RelationManagers\PairingsRelationManager::class,
            RelationManagers\BlacklistItemsRelationManager::class,
            RelationManagers\ReportsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
