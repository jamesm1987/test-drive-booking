<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeSlotResource\Pages;
use App\Filament\Resources\TimeSlotResource\RelationManagers;
use App\Models\TimeSlot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;

//Layout
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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;

// Columns
use Filament\Tables\Columns\TextColumn;

class TimeSlotResource extends Resource
{
    protected static ?string $model = TimeSlot::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('event_id')
                ->relationship('event', 'name'),
                Select::make('time_slot_intervals')->options([
                    '30' => '30 Minutes', '60' => '1 Hour'
                ]),
                TimePicker::make('start_time')->label('First Booking')->seconds(false),
                TimePicker::make('end_time')->label('Last Booking')->seconds(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.name'),
                TextColumn::make('start_time')->label('From'),
                TextColumn::make('end_time')->label('To')
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

    public static function generateTimeSlots($startTime, $endTime, $interval)
    {
        $timeSlots = [];
        $currentStart = $startTime;

        while ($currentStart < $endTime) {
            $currentEnd = $currentStart->copy()->addMinutes($interval);

            if ($currentEnd > $endTime) {
                $currentEnd = $endTime;
            }

            $timeSlots[] = [
                'start_time' => $currentStart->format('H:i:s'),
                'end_time' => $currentEnd->format('H:i:s'),
            ];

            $currentStart = $currentEnd;
        }

        return $timeSlots;
    }

    public static function createMultiple(array $data)
    {
        // Convert interval to minutes
        $intervals = [
            '30 Minutes' => 30,
            '1 Hour' => 60,
        ];
        $interval = $intervals[$data['time_slot_intervals']] ?? 30;

        // Generate time slots
        $timeSlots = self::generateTimeSlots(
            Carbon::parse($data['start_time']),
            Carbon::parse($data['end_time']),
            $interval
        );

        // Create time slots
        foreach ($timeSlots as $slot) {
            TimeSlot::create([
                'event_id' => $data['event_id'],
                'start_time' => $slot['start_time'],
                'end_time' => $slot['end_time'],
            ]);
        }
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
            'index' => Pages\ListTimeSlots::route('/'),
            'create' => Pages\CreateTimeSlot::route('/create'),
            'edit' => Pages\EditTimeSlot::route('/{record}/edit'),
        ];
    }
}
