<?php 

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\BookBed;

class BookBedRule implements Rule
{
    protected $bed;
    protected $date;
    protected $endDate; // New parameter: endDate
    protected $startTime;
    protected $endTime;

    public function __construct($bed, $date, $endDate, $startTime, $endTime)
    {
        $this->bed = $bed;
        $this->date = $date;
        $this->endDate = $endDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function passes($attribute, $value)
    {
        $conflictingBookings = BookBed::where('bed_id', $this->bed)
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->whereBetween('start_time', [$this->startTime, $this->endTime])
                        ->orWhereBetween('end_time', [$this->startTime, $this->endTime]);
                })
                ->orWhere(function ($query) {
                    $query->where('start_time', '<', $this->startTime)
                        ->where('end_time', '>', $this->endTime);
                });
            })
            ->where(function ($query) {
                $query->where('date', '=', $this->date)
                    ->orWhere('end_date', '=', $this->endDate); // Check for overlapping bookings on both start and end dates
            })
            ->exists();

        return !$conflictingBookings;
    }

    public function message()
    {
        return 'Slot unavailable';
    }
}
