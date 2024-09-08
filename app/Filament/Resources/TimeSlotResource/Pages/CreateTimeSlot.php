<?php

namespace App\Filament\Resources\TimeSlotResource\Pages;

use App\Filament\Resources\TimeSlotResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTimeSlot extends CreateRecord
{
    protected static string $resource = TimeSlotResource::class;

    // Override the create method with the correct signature
    public function create(bool $another = false): void
    {
        // Call a custom method to handle the creation logic
        $this->createMultipleRecords();

        // Optionally handle redirection or other logic after creation
        $this->redirect('/time-slots');
    }

    protected function createMultipleRecords(): void
    {
        // Get the form data
        $data = $this->form->getState();

        // Call the static method to create multiple records
        TimeSlotResource::createMultiple($data);
    }
}
