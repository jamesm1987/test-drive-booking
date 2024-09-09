<?php

namespace App\Filament\Actions;

use Filament\Forms\Components\Actions\Action;
use Carbon\Carbon;
use App\Models\TimeSlot;

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
                $interval = intval($get('time_slot_interval'));

                $start = Carbon::parse($startTime);
                $end = Carbon::parse($endTime);

                // Array to hold generated time slots
                $generatedTimeSlots = [];

                // Loop to generate time slots
                while ($start->lt($end)) {
                    $nextSlot = $start->copy()->addMinutes($interval);

                    if ($nextSlot->greaterThan($end)) {
                        break;
                    }

                    $generatedTimeSlots[] = new TimeSlot([
                            'event_id' => $this->record ? $this->record->id : null,
                            'start_time' => $start->format('H:i'),
                            'end_time' => $nextSlot->format('H:i'),
                    
                    ]);

                    $start = $nextSlot;
                }

                
                $this->record->timeslots()->delete();

                $this->record->timeslots()->saveMany($generatedTimeSlots);

                info('Generated time slots:', $generatedTimeSlots);
            });
    }
}