<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;

class BookingService
{
    public function __construct()
    {
    }

    public function create()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'full_name' => ['required'],
            'address' => ['required'],
            'phone_no' => ['required'],
            'survey_type' => ['required'],
            'schedule_date' => ['required'],
            'land_location' => ['required'],
            'appointment_notes' => [''],
            'time_slot_id' => ['required', 'exists:time_slots,id'],
        ]);

        if($validator->fails()) {
            throw new ValidationException($validator->errors());
        }
    }
}
