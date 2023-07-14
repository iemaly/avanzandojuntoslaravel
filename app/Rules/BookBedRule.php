<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\BookBed;

class BookBedRule implements Rule
{
    protected $bed;
    protected $date;
    protected $startTime;
    protected $endTime;

    public function __construct($bed, $date, $startTime, $endTime)
    {
        $this->bed = $bed;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function passes($attribute, $value)
    {
        $conflictingBookings = BookBed::where(['date'=>$this->date, 'bed_id'=>$this->bed])
            ->where(function ($query) {
                $query->whereBetween('start_time', [$this->startTime, $this->endTime])
                    ->orWhereBetween('end_time', [$this->startTime, $this->endTime])
                    ->orWhere(function ($query) {
                        $query->where('start_time', '<', $this->startTime)
                            ->where('end_time', '>', $this->endTime);
                    });
            })
            ->exists();

        return !$conflictingBookings;
    }

    public function message()
    {
        return 'Slot unavailable';
    }
}
