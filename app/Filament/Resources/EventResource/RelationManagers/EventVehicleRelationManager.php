<?php
namespace App\Filament\Resources\EventResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;


class EventVehicleRelationManager extends RelationManager
{
    protected static string $relationship = 'vehicles';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('vehicles')  // Field name should match the relationship name in Vehicle model
                    ->relationship('vehicles', 'title')
                    ->preload()
                    ->multiple()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),  // Display event names
            ])
            ->filters([
                // Define any filters if needed
            ])
            ->headerActions([
                // Define header actions if needed
            ])
            ->actions([
                // Define row actions if needed
            ])
            ->bulkActions([
                // Define bulk actions if needed
            ]);
    }
}
