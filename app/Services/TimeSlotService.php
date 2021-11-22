<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Booking;
use App\Models\TimeSlot;
use Facade\FlareClient\Time\Time;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Str;

class TimeSlotService
{
    public function __construct()
    {
    }

    public function getAll()
    {
        return TimeSlot::all();
    }
}
