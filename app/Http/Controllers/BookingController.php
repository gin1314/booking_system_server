<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Services\BookingService;
use App\Transformers\BookingTransformer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     *
     * @var BookingService
     */
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function getBooking(Booking $booking)
    {
        $booking = $this->bookingService->getBooking($booking);
        return fractal($booking, new BookingTransformer())->respond();
    }

    public function getAll()
    {
        $bookings = $this->bookingService->getAllBooking();
        return fractal($bookings, new BookingTransformer())->respond();
    }

    public function create()
    {
        $booking = $this->bookingService->create();

        return fractal($booking, new BookingTransformer())->respond();
    }

    public function confirmBooking(Booking $booking)
    {
        $booking = $this->bookingService->confirmBooking($booking);

        return fractal($booking, new BookingTransformer())->respond();
    }

    public function completeBooking(Booking $booking)
    {
        $booking = $this->bookingService->completeBooking($booking);

        return fractal($booking, new BookingTransformer())->respond();
    }

    public function assignBooking(Booking $booking)
    {
        $booking = $this->bookingService->assignBooking($booking);

        return fractal($booking, new BookingTransformer())->respond();
    }

    public function cancelBooking(Booking $booking)
    {
        $booking = $this->bookingService->cancelBooking($booking);

        return fractal($booking, new BookingTransformer())->respond();
    }
}
