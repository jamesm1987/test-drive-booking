<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Vehicle;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Manufacturer;


// Layout
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;

// Inputs
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\CheckboxList;
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
    $model = $form->model;
    
    return $form
        ->schema([
            Section::make('Create a vehicle')
                ->description('create a new vehicle')
                ->schema([
                    TextInput::make('title'),
                    TextInput::make('number'),
                    TextInput::make('model'),
                    TextInput::make('registration')
            ])->columnSpan(2)->columns(2),
            Group::make()->schema([
                Section::make("Image")
                    ->collapsible()
                    ->schema([
                        FileUpload::make('img_url')
                        ->label('Upload Image')
                        ->disk('public')
                        ->directory('vehicles'),
                    ])
            ])->columnSpan(1),
            Section::make("Meta")->schema([
                Select::make("manufacturer_id")
                ->label('Manufacturer')
                ->relationship('manufacturer', 'name')
                ->nullable()
                ->required(),


                Repeater::make('vehicleAttributes')

                    ->label('Attributes')
                    ->relationship()

                    ->schema([

                        Select::make('attribute_id')
                            ->label('Attribute')
                            ->options(Attribute::pluck('name', 'id'))
                            ->reactive()
                            ->required()
                            ->unique(), // Ensure each attribute_id is unique
                        Select::make('attribute_value_id')
                            ->label('Value')
                            ->options(function (callable $get) {
                                $attributeId = $get('attribute_id');

                                return $attributeId
                                    ? AttributeValue::where('attribute_id', $attributeId)->pluck('name', 'id')
                                    : [];
                            })->required(),
                    ])
                    ->saveRelationshipsUsing(function($record, $state) {
                        $vehicleAttributes = [];

                        foreach ($state as $items) {
                            if (!empty($items['attribute_value_id'])) {
                                foreach ($items['attribute_value_id'] as $attributeValueId) {

                                    $vehicleAttributes[] = [
                                        'attribute_id' => $items['attribute_id'],
                                        'attribute_value_id' => $attributeValueId
                                    ];
                                }
                            }
                        }

                        $record->attributeValues()->sync($vehicleAttributes);
                    })
            ]),       
    
        ])->columns([
            'default' => 3,
            'sm' => 3,
            'md' => 3,
            'lg' => 3
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('model'),
                ImageColumn::make('img_url')->label('Image'),
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

    public static function beforeFill($record, $data)
    {
        $data['attributes'] = $record->attributes->map(function ($attribute) {
            return [
                'attribute_id' => $attribute->id,
                'attribute_value_id' => $attribute->pivot->attribute_value_id,
            ];
        })->toArray();

        return $data;
    }
}
