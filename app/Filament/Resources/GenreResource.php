<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GenreResource\Pages;
use App\Models\Genre;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'Music';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                                Forms\Components\TextInput::make('slug'),
                            ]),
                        SpatieMediaLibraryFileUpload::make('icon'),
                        Forms\Components\Fieldset::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\ColorPicker::make('primary_color'),
                                Forms\Components\ColorPicker::make('secondary_color'),
                            ]),
                        Forms\Components\Fieldset::make()
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('order')
                                    ->numeric(),
                                Forms\Components\TextInput::make('position_x')
                                    ->numeric(),
                                Forms\Components\TextInput::make('position_y')
                                    ->numeric(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                SpatieMediaLibraryImageColumn::make('icon')
                    ->size(100),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
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
            'index' => Pages\ManageGenre::route('/'),
        ];
    }
}
