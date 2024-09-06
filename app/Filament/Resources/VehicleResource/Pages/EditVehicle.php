<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Resources\VehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use Illuminate\Support\Str;

class EditVehicle extends EditRecord
{
    protected static string $resource = VehicleResource::class;
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['slug'] = Str::slug("{$data['title']}");

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $attributes = $this->form->getState()['attributes'];

        $syncData = [];

        foreach ($attributes as $attribute) {
            $attributeId = $attribute['attribute_id'];
            $valueIds = $attribute['attribute_value_ids'];

            foreach ($valueIds as $valueId) {
                $syncData[] = [
                    'attribute_id' => $attributeId,
                    'attribute_value_id' => $valueId,
                ];
            }
        }
        $this->record->attributes()->sync(
            $syncData
        );
    }
}
