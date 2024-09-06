<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\AttributeValue;
use App\Models\Manufacturer;


// Inputs
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;

// Columns
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {


    $manufacturers = Manufacturer::all();

    return $form->schema([
        FileUpload::make('img_url')
            ->label('Upload Image')
            ->disk('public')
            ->directory('vehicles'),
        TextInput::make('title'),
        TextInput::make('number'),
        TextInput::make('model'),
        TextInput::make('registration'),

        Select::make("manufacturer_id")
            ->label('Manufacturer')
            ->relationship('manufacturer')
            ->options($manufacturers->pluck('name', 'id'))
            ->nullable()
            ->required(),

            Repeater::make('attributes')
                ->relationship('attributes')
                ->schema([
                    Select::make('attribute_id')
                        ->relationship('attributes', 'name')
                        ->label('Attribute')
                        ->required(),
                    Select::make('attribute_value_ids')
                        ->relationship('attributeValues', 'value')
                        ->label('Values')
                        ->multiple()
                        ->required(),
            ])
            ->label('Attributes & Values')
            ->columns(2)
            ->collapsed(false)

        // foreach ($attributes as $key => $attribute) {
        //     $schema[] = Select::make("attributeValues")
        //         ->label($attribute->name)
        //         ->options($attribute->values()->pluck('name', 'id'))
        //         ->relationship('attributeValues', 'name')
        //         ->nullable();
        // }


        // foreach ($attributes as $attribute) {
            
        //     $selectedValues = $form->model->attributeValues
        //     ->where('attribute_id', $attribute->id)
        //     ->pluck('id')
        //     ->toArray();
        //     dd($selectedValues);
    
        //     $schema[] = Select::make("attributes.{$attribute->id}")
        //         ->label($attribute->name)
        //         ->options($attribute->values->pluck('name', 'id'))
        //         ->default(6)
        //         ->nullable();
        // }
    
    ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('model'),
                ImageColumn::make('img_url'),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }

    public function afterSave(): void
{
    $selectedAttributeValues = $model->form->getState()['attribute_value_id'];

    // Assuming `$this->record` is your vehicle or related model
    $model->form->attributeValues()->sync($selectedAttributeValues);
}
}
