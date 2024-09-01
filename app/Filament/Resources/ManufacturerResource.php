<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManufacturerResource\Pages;
use App\Filament\Resources\ManufacturerResource\RelationManagers;
use App\Models\Manufacturer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// Inputs
use Filament\Forms\Components\TextInput;

// Columns
use Filament\Tables\Columns\TextColumn;

class ManufacturerResource extends Resource
{
    protected static ?string $model = Manufacturer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
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
            'index' => Pages\ListManufacturers::route('/'),
            'create' => Pages\CreateManufacturer::route('/create'),
            'edit' => Pages\EditManufacturer::route('/{record}/edit'),
        ];
    }
}
