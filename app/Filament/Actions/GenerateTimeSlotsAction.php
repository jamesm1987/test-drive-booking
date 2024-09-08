<?php

namespace App\Filament\Actions;

use Filament\Forms\Components\Actions\Action;
use Carbon\Carbon;

class GenerateTimeSlotsAction extends Action
{

    protected $record;

    public function record($record): static
    {
        $this->record = $record;
        return $this;
    }

    protected function setUp(): void
    {
        
        parent::setUp();

        $this->label('Generate Time Slots')
            ->action(function (callable $get, callable $set) {

                $event = $this->record ? $this->record->id : null;
                $startTime = $get('start_time');
                $endTime = $get('end_time');
                $interval = $get('time_slot_interval');

                $start = Carbon::parse($startTime);
                $end = Carbon::parse($endTime)->subMinutes($interval);

                $intervals = [
                    '30 Minutes' => 30,
                    '1 Hour' => 60,
                ];

                $timeSlotInterval = $intervals[$interval] ?? 30; // Default to 30 minutes

                // Array to hold generated time slots
                $generatedTimeSlots = [];

                // Loop to generate time slots
                while ($start->lt($end)) {
                    $nextSlot = $start->copy()->addMinutes($timeSlotInterval);

                    if ($nextSlot->gt($end)) {
                        break;
                    }

                    $generatedTimeSlots[] = [
                        'event_id' => $this->record ? $this->record->id : null,
                        'start_time' => $start->format('H:i'),
                        'end_time' => $nextSlot->format('H:i'),
                    ];

                    $start = $nextSlot;
                }

                dd($generatedTimeSlots);

                info('Generated time slots:', $generatedTimeSlots);
            });
    }
}