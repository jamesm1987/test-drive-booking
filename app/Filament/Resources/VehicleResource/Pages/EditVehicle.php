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
            Actions\DeleteAction::make()
        ];
    }

}
