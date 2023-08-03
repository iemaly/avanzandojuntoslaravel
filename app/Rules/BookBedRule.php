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
        if (!BookBed::where(['life_time'=>1, 'bed_id'=>$this->bed])->exists()) 
        {
            $date = $this->date;
            $endDate = $this->endDate;
            $startTime = $this->startTime;
            $endTime = $this->endTime;
            $conflictingBookings = BookBed::where('bed_id', $this->bed)
                ->where(function ($query) use ($date, $endDate, $startTime, $endTime) {
                    $query->whereRaw("CONCAT(book_beds.`end_date`, ' ', book_beds.`end_time`) BETWEEN ? AND ?", [
                        \Carbon\Carbon::parse($date)->format("Y-m-d") . " " . $startTime,
                        \Carbon\Carbon::parse($endDate)->format("Y-m-d") . " " . $endTime
                    ])->orWhereRaw("CONCAT(book_beds.`date`, ' ', book_beds.`start_time`) BETWEEN ? AND ?", [
                        \Carbon\Carbon::parse($date)->format("Y-m-d") . " " . $startTime,
                        \Carbon\Carbon::parse($endDate)->format("Y-m-d") . " " . $endTime
                    ]);
                })->exists();
            return !$conflictingBookings;
        }
        return false;
    }

    public function message()
    {
        if (BookBed::where(['life_time'=>1, 'bed_id'=>$this->bed])->exists()) return "Bed is booked for lifetime";
        return 'Slot unavailable';
    }
}
