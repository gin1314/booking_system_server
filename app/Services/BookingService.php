<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Mail\BookingAssigned;
use App\Mail\BookingCompleted;
use App\Mail\BookingConfirmed;
use App\Mail\BookingCreated;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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
            'email' => ['required', 'email'],
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
                        'The schedule is full on this date and time, choose another date and time'
                    ],
                    // 'schedule_date' => ['T']
                ]);
            }
            throw new ValidationException($e->getMessage());
        }

        Mail::to($booking->email)->queue(
            new BookingCreated($booking)
        );

        return $booking;
    }

    public function getBooking(Booking $booking)
    {
        return $booking;
    }

    public function getAllBooking()
    {
        $bookings = QueryBuilder::for(Booking::class)
            ->allowedSorts(['schedule_date', 'id', 'created_at', 'updated_at'])
            ->allowedIncludes(['user'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                'user_id',
                'last_name',
                'first_name',
                'phone_no',
                'email',
                'status'
            ])
            ->paginate(request()->get('per_page'));

        return $bookings;
    }

    /**
     * Booking confirmed business logic, it send an email to the client
     * @param Booking $booking
     * @return Booking
     * @throws BindingResolutionException
     * @throws AuthorizationException
     * @throws InvalidArgumentException
     * @throws InvalidCastException
     */
    public function confirmBooking(Booking $booking)
    {
        if (auth()->user()->role !== 'engineer') {
            throw new AuthorizationException(
                'This action is unauthorized.',
                403
            );
        }

        $booking->status = 'confirmed';
        $booking->user_id = auth()->user()->id;

        $booking->save();

        Mail::to($booking->email)->queue(
            new BookingConfirmed($booking, auth()->user())
        );

        return $booking;
    }

    /**
     * Booking complete business logic, it send an email to the client
     * @param Booking $booking
     * @return Booking
     * @throws BindingResolutionException
     * @throws AuthorizationException
     * @throws InvalidArgumentException
     * @throws InvalidCastException
     */
    public function completeBooking(Booking $booking): Booking
    {
        if (auth()->user()->role !== 'engineer') {
            throw new AuthorizationException(
                'This action is unauthorized.',
                403
            );
        }

        $booking->status = 'completed';
        $booking->user_id = auth()->user()->id;

        $booking->save();

        Mail::to($booking->email)->queue(
            new BookingCompleted($booking, auth()->user())
        );

        return $booking;
    }

    public function assignBooking(Booking $booking): Booking
    {
        if (
            !empty($booking->user_id) &&
            $booking->user_id !== auth()->user()->id
        ) {
            throw new AuthorizationException(
                'This action is unauthorized.',
                403
            );
        }

        $validator = Validator::make(request()->all(), [
            'user_id' => ['required', 'exists:users,id']
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        $booking->status = 'pending';
        $booking->user_id = request()->get('user_id');
        $booking->save();

        Mail::to($booking->email)->queue(
            new BookingAssigned($booking, User::find(request()->get('user_id')))
        );

        return $booking;
    }
}
