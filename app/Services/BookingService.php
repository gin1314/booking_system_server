<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Booking;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookingService
{
    public function __construct()
    {
    }

    public function create()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'client_street' => ['required'],
            'client_city' => ['required'],
            'client_region' => ['required'],
            'client_postal_code' => [''],
            'land_street' => ['required'],
            'land_city' => ['required'],
            'land_region' => ['required'],
            'land_postal_code' => [''],
            'email' => ['email'],
            'phone_no' => ['required'],
            'survey_type' => [
                'required',
                'in:' . implode(',', Booking::SURVEY_TYPES)
            ],
            'schedule_date' => ['required', 'date'],
            'appointment_notes' => [''],
            'time_slot_id' => ['required', 'exists:time_slots,id']
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        try {
            $d = json_encode($data['requirements']);
            unset($data['requirements']);
            $booking = Booking::create($data);
            $booking->requirements = $d;
            $booking->uuid = Str::uuid();
            $booking->save();
        } catch (QueryException $e) {
            if (preg_match('|Duplicate entry|', $e->getMessage())) {
                throw new ValidationException([
                    'time_slot_id' => [
                        'This time slot has already been booked'
                    ],
                    'schedule_date' => ['This schedule has already been booked']
                ]);
            }
            throw new ValidationException($e->getMessage());
        }

        return $booking;
    }

    public function getBooking(Booking $booking)
    {
        return $booking;
    }
}
